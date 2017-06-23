<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ionicons -->
    <link rel="icon" type="image/png" href="/favicon.png">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.4.6.0.css">
    <link rel="stylesheet" type="text/css" href="/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="/css/mall.css">
    <!-- Jquery -->
    <script src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/slick.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        $().ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel
                }
            });
        })
    </script>
</head>
<body>
<div id="login">
    <div class="container">今日:{{Session::get('discuz.post.today_count')}} 昨日:{{Session::get('discuz.post.yesterday_count')}} 帖子:{{Session::get('discuz.post.count')}} 会员:{{Session::get('discuz.user.count')}} 欢迎新会员:{{Session::get('discuz.user.latest')}}</div>
</div>
<header class="navbar navbar-static-top bs-docs-nav" id="top">
    <div class="container">
        <div class="row">
            <img src="/images/mall/logo.jpg" />
            <div class="pull-right">
                <div style="width:200px;margin-top:40px;">
                    <div class="input-group" id="search">
                        <input type="text" class="form-control" placeholder="搜索帖子" />
                        <div class="input-group-btn">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <nav id="bs-navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="/bbs" >车型论坛</a>
                    </li>
                    <li>
                        <a href="/" >车主聚会</a>
                    </li>
                    <li class="active">
                        <a href="/mall" >积分商城</a>
                    </li>
                    <li>
                        <a href="http://dffengguang.com.cn/" >风光官网</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="margin-right:0;">
                    <li><a href="javascript:;">分享至</a></li>
                    <li><a href="/" target="_blank"><img src="/images/mall/icon-qq.jpg" height="48"/></a></li>
                    <li><a href="/" target="_blank"><img src="/images/mall/icon-wechat.jpg" height="48"/></a></li>
                    <li><a href="/" target="_blank"><img src="/images/mall/icon-weibo.jpg" height="48"/></a></li>
                    <li><a href="/" target="_blank"><img src="/images/mall/icon-qzone.jpg" height="48"/></a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
@yield('content')
<footer>
    <div class="container">

        <div class="pull-right" id="footer-services">
            <div class="rows">
                <h4>24小时关怀热线</h4>
                <h2>400-887-5551</h2>
                <p>ICP备案号：渝ICP备16003854号-1</p>
            </div>
        </div>
        <div class="row" id="footer-navbar">
            <div class="col-md-2"><a href="/">首页</a></div>
            <div class="col-md-2">
                <a href="#">车型展示</a>
                <ul class="nav">
                    <li><a href="/index.php/Index/page580">风光580</a></li>
                    <li><a href="/index.php/Index/page370">风光370</a></li>
                    <li><a href="/index.php/Index/page360">风光360</a></li>
                    <li><a href="/index.php/Index/page360b">风光360欧洲柴油版</a></li>
                    <li><a href="/index.php/Index/page330">风光330</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <a href="#">购车支持</a>
                <ul class="nav">
                    <li><a href="/index.php/Index/gczc/type/1">预约试驾</a></li>
                    <li><a href="/index.php/Index/gczc/type/2">专营店查询</a></li>
                    <li><a href="/index.php/Index/zxgc">在线购车</a></li>
                    <li><a href="/index.php/Index/gczc/type/4">天猫旗舰店</a></li>
                    <li><a href="/index.php/Index/gczc/type/5">型录索取</a></li>
                    <li><a href="/index.php/Index/gczc/type/6">集团购车</a></li>
                </ul>
                </li>
            </div>
            <div class="col-md-2">
                <a href="#">风光动态</a>
                <ul class="nav">
                    <li><a href="/index.php/Index/fgdt/newstypeid/1">风光资讯</a></li>
                    <li><a href="/index.php/Index/fgdt/newstypeid/3">活动促销</a></li>
                    <li><a href="/index.php/Index/fgdt/newstypeid/2">媒体声音</a></li>
                </ul>
                </li>
            </div>
            <div class="col-md-2">
                <a href="#">关于东风风光</a>
                <ul class="nav">
                    <li><a href="/index.php/Index/about/type/1">品牌介绍</a></li>
                    <li><a href="/index.php/Index/about/type/2">精彩视频</a></li>
                    <li><a href="/index.php/Index/about/type/3">壁纸欣赏</a></li>
                    <li><a href="/index.php/Index/about/type/4">联系我们</a></li>
                    <li><a href="/index.php/Index/about/type/5">经销商招募</a></li>
                </ul>
                </li>
            </div>
            <div class="col-md-2">
                <a href="#">售后服务</a>
                <ul class="nav">
                    <li><a href="javascript:;">售后服务</a></li>
                    <li><a href="/index.php/Index/shfw/type/1">服务承诺</a></li>
                    <li><a href="/index.php/Index/shfw/type/2">服务站点查询</a></li>
                    <li><a href="/index.php/Index/shfw/type/3">售后手册公示</a></li>
                </ul>
                </li>
            </div>
            <div id="footer-bottom-right"></div>
        </div>
        <div class="row" id="footer-logo">
            <img src="/images/mall/footer-logo.jpg" with="150" height="48" />
        </div>
    </div>
</footer>

<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">请登录</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(array('url' => url('/discuz/login'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'login-form')) }}
                <div class="form-group" id="form-group-username">
                    <label for="username" class="col-md-2 col-xs-2 control-label">用户名:</label>
                    <div class="col-md-10 col-xs-10">
                        <input class="form-control" type="text" value="" id="username" name="username">
                        <label class="help-block" for="username" id="help-username"></label>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group" id="form-group-password">
                    <label for="price" class="col-md-2 col-xs-2 control-label">密码:</label>
                    <div class="col-md-10 col-xs-10">
                        <input class="form-control" type="password" value="" id="password" name="password">
                        <label class="help-block" for="password" id="help-password"></label>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                <div class="form-group">
                    <div class="col-md-10 col-xs-10 col-md-offset-2">
                        <button type="submit" class="btn btn-custom">登录</button>
                    </div><!-- /.col -->
                </div><!-- /form-group -->
                {{ Form::close() }}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="modal-tip" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="">购买失败</h4>
            </div>
            <div class="modal-body">
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script src="{{asset('js/jquery.form.js')}}"></script>
<script>
    $().ready(function () {
        $('#login-form').ajaxForm({
            dataType: 'json',
            success: function(json) {
                $('.help-block').html('');
                $('.form-group').removeClass('has-error');
                if (json.ret == 0){
                    $.get(json.url,function () {
                        $('#modal-login').modal('hide');
                        $('#modal-address').modal('show');
                    }).fail(function () {
                        $('#help-password').html('<span class="text-danger">服务器发生错误，请稍候重试。</span>');
                    });
                }
                else if(json.ret == 1001){
                    $('#form-group-username').addClass('has-error');
                    $('#help-username').html(json.msg);
                }
                else{
                    $('#form-group-password').addClass('has-error');
                    $('#help-password').html(json.msg);
                }
            },
            error: function(xhr){
                //$('#form-group-password').addClass('has-error');
                $('#help-password').html('<span class="text-danger">服务器发生错误，请稍候重试。</span>');
            }
        });

    })

</script>
@yield('scripts')
</body>
</html>
