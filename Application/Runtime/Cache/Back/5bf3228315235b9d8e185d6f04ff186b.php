<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html dir="ltr" lang="zh-CN">
<head>
    <meta charset="UTF-8" />
    <title>欢迎来到商店后台管理系统</title>
    <base href="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <script type="text/javascript" src="/daniu/php4/buyplus/Public/Back/jquery/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="/daniu/php4/buyplus/Public/Back/bootstrap/js/bootstrap.min.js"></script>
    <link href="/daniu/php4/buyplus/Public/Back/bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
    <link href="/daniu/php4/buyplus/Public/Back/font-awesome/css/font-awesome.min.css" type="text/css" rel="stylesheet" />
    <link type="text/css" href="/daniu/php4/buyplus/Public/Back/stylesheet/stylesheet.css" rel="stylesheet" media="screen" />
    <script src="/daniu/php4/buyplus/Public/Back/javascript/common.js" type="text/javascript"></script>


</head>
<body>
<div id="container">
    <header id="header" class="navbar navbar-static-top">
        <div class="navbar-header">
            <a href="" class="navbar-brand"><img src="/daniu/php4/buyplus/Public/Back/image/logo.png" alt="BuyPlus" title="BuyPlus" /></a></div>
    </header>
    <div id="content">
        <div class="container-fluid"><br />
            <br />
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h1 class="panel-title"><i class="fa fa-lock"></i> 请输入您的登录信息。</h1>
                        </div>
                        <div class="panel-body">
                            <?php if(isset($message['errorInfo'])): ?><div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> 用户名或密码不存在！              <button type="button" class="close" data-dismiss="alert">×</button>
                                </div><?php endif; ?>
                            <form action="<?php echo U('login');?>" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="input-username">商店管理</label>
                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        <input type="text" name="username" value="" placeholder="商店管理" id="input-username" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-password">安全密码</label>
                                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input type="password" name="password" value="" placeholder="安全密码" id="input-password" class="form-control" />
                                    </div>
                                    <span class="help-block"><a href="">忘记密码</a></span>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-key"></i> 登录</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <a href="http://www.hellokang.net">BuyPlus(败家Shopping) HelloKang</a>
        <br>
        &copy; 2009-2016 All Rights Reserved.
        <br>Version 1.0
    </footer></div>
</body>

</html>