<?php


namespace Home\Controller;


use Home\Cart\Cart;
use Think\Controller;

class BuyController extends Controller
{
    /**
     * 添加商品到购物车
     */
    public function addToCartAction()
    {
        // 请求代理(前端), 需要请求的数据
        $goods_id = I('request.goods_id', null);
        $product_id = I('request.product_id', null);
        $buy_quantity = I('request.buy_quantity', 1, 'intval');

        // 调用购物车, 完成购物车添加
        $cart = Cart::instance();// 单例 实例购物车类
        $cart->addWare($goods_id, $product_id, $buy_quantity);// 添加购买的商品
//        dump($cart);
        $this->ajaxReturn(['error'=>0]);
    }

    /**
     * 获取购物车中信息
     */
    public function cartInfoAction()
    {
        $cart = Cart::instance();// 单例  实例化购物车类
        $info = $cart->getInfo();

        $this->ajaxReturn(['error'=>0, 'data'=>$info]);
    }

    public function removeFromCartAction()
    {
        $key = I('request.key', null);
        $cart = Cart::instance();
        $cart->removeWare($key);
        $this->ajaxReturn(['error'=>0]);
    }

    //结账展示
    public function cartAction()
    {
        $this->display();
    }

    /**
     * 校验是否否登陆
     */
    public function checkoutAction()
    {
        // 登录之后才可以展示
        if (! session('member')) {
            // 记录下, 登录成功后的目标URL
            session('successUrl', ['route' => '/checkout', 'param' => []]);
            // 未登录 跳转到登陆页面
            $this->redirect('/login');
        }

        $this->display();

    }

    /**
     * 配送列表
     */
    public function shippingListAction()
    {
        $list = M('Shipping')->where(['enabled'=>1])->select();
        foreach($list as $k=>$shipping) {
            // 计算每种运费的价格
            $shippingName = 'Common\Shipping\\' . $shipping['key'];
            $shipping = new $shippingName;
            $list[$k]['price'] = $shipping->price();
        }
        $this->ajaxReturn(['error'=>0, 'data'=>$list?$list:[]]);
    }

    public function orderAction()
    {
        // 登录之后才可以展示
        if (! session('member')) {
            // 记录下, 登录成功后的目标URL
            session('successUrl', ['route' => '/checkout', 'param' => []]);
            // 未登录
            $this->redirect('/login');
        }

        // 加入订单到队列
        $redis = new \Redis();
        $redis->connect('127.0.0.1', '6379'); //链接
        $orderInfo = I('post.');//订单信息，不含订单商品
        // 从购物车中获取的 商品信息
        $cart = Cart::instance();//实例化购物车类
        $orderInfo['cartInfo'] = $cart->getInfo(); //将购物车信息合并到订单信息中

        // 会员id
        $orderInfo['member_id'] = session('member.member_id');//会员id合并到订单表

        $redis->hSet('orderResult', 'member-'.$orderInfo['member_id'], 'processing');//将会员结果域中的会员id字段值设为正在处理

        $redis->lpush('orderList', serialize($orderInfo));//左侧压入链表

        $this->ajaxReturn(['error'=>0]);//返回  不
    }

    public function resultAction(){
        //登陆之后可以展示
        if(!session('member')){ //判断是否登陆
            //记录登陆后成功后的URL
            session('successUrl',['route' =>'/checkout','param'=>[]]);
            //未登录 重定向到登陆界面
            $this->redirect('/login');
        }
        $this->display();
    }

    /**
     * 轮询处理
     */
//    public function orderStateAction()
//    {
//        // 登录之后才可以展示
//        if (! session('member')) {
//            // 记录下, 登录成功后的目标URL
//            session('successUrl', ['route' => '/checkout', 'param' => []]);
//            // 未登录
//            $this->redirect('/login');
//        }
//        // 检测订单的状态.
//        // 加入订单到队列
//        $redis = new \Redis();
//        $redis->connect('127.0.0.1', '6379');
//        $data = $redis->hGet('orderResult', 'member-'.session('member.member_id'));
//
//        switch ($data) {
//            case 'success':
//                $this->ajaxReturn(['error'=>0]);
//                break;
//            case 'processing':
//                $this->ajaxReturn(['error'=>2]);
//                break;
//
//            case 'quantity error':
//            case 'order error':
//                $this->ajaxReturn(['error'=>1]);
//                break;
//        }

    /**
     * 长轮询
     */
    public function orderStateAction()
    {
        // 登录之后才可以展示
        if (! session('member')) {
            // 记录下, 登录成功后的目标URL
            session('successUrl', ['route' => '/checkout', 'param' => []]);
            // 未登录
            $this->redirect('/login');
        }
        // 检测订单的状态.
        // 加入订单到队列
        $redis = new \Redis();
        $redis->connect('127.0.0.1', '6379');
        do {
            $data = $redis->hGet('orderResult', 'member-'.session('member.member_id'));

        } while($data == 'processing');


        switch ($data) {
            case 'success':
                $this->ajaxReturn(['error'=>0]);
                break;
            case 'quantity error':
            case 'order error':
                $this->ajaxReturn(['error'=>1]);
                break;
        }

    }


}