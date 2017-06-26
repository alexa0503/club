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
    <div class="container">
        <ul class="nav navbar-nav navbar-right">
            @if(!Session::get('discuz.hasLogin'))
            <li class="login"><a href="/bbs/member.php?mod=logging&amp;action=login&amp;referer={{url('/mall')}}">登录</a></li>
            <li class="login"><a href="/bbs/member.php?mod=register">注册</a></li>
            @else
            <li><a href="/bbs/home.php?mod=space&amp;uid=1" target="_blank" title="访问我的空间">{{Session::get('discuz.user.username')}}</a></li>
            <li>|</li>
            <li><a href="/bbs/home.php?mod=spacecp">我的</a></li>
            <li><a href="/bbs/home.php?mod=spacecp&amp;ac=credit&amp;showcredit=1">风迷币: {{Session::get('discuz.user.user_count.extcredits4')}}</a></li>
            <li><a href="/bbs/home.php?mod=spacecp&amp;ac=usergroup">用户组: {{Session::get('discuz.user.user_group.grouptitle')}}</a></li>
            <li><a href="/bbs/home.php?mod=space&amp;do=notice" id="myprompt" class="a showmenu" onmouseover="showMenu({'ctrlid':'myprompt'});">提醒</a></li>
            <li>|</li>
            @if(Session::get('discuz.user.groupid') == 1)
            <li><a href="/admin">商城管理</a></li>
            <li><a href="/bbs/admin.php" target="_blank">管理中心</a></li>
            @endif
            <li><a href="/bbs/member.php?mod=logging&amp;action=logout" id="logout">退出</a></li>
            @endif
        </ul>


    </div>
</div>
<header class="navbar navbar-static-top bs-docs-nav" id="top">
    <div class="container">
        <div class="row">
            <a href="/bbs"><img src="/images/mall/logo.jpg" /></a>
            <div class="pull-right">
                <div class="thread-top" style="">今日: <em>{{session('discuz.forum.todayposts')}}</em><span class="pipe">|</span>昨日: <em>{{session('discuz.forum.yesterdayposts')}}</em><span class="pipe">|</span>帖子: <em>{{session('discuz.forum.posts')}}</em><span class="pipe">|</span>会员: <em>{{session('discuz.user_count')}}</em><span class="pipe">|</span>欢迎新会员: <a href="/bbs/home.php?mod=space&uid={{session('discuz.latest_user.uid')}}&do=profile">{{session('discuz.latest_user.username')}}</a></div>
                <div style="width:285px;margin-top:20px;float:left;">
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
                        <a href="/" >首页</a>
                    </li>
                    <li>
                        <a href="/bbs" >车型论坛</a>
                    </li>
                    <li>
                        <a href="/bbs" >车主聚会</a>
                    </li>
                    <li>
                        <a href="/mall" >积分商城</a>
                    </li>
                    <li>
                        <a href="http://dffengguang.com.cn/" >风光官网</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right" style="margin-right:0;">
                    <li><a href="javascript:;">分享至</a></li>
                    <li><a href="javascritp:;" target="_blank" class="weixin"><img src="/bbs/static/assets/imgs/layout/wc_icon.png" height="29" style="padding-bottom:2px;"/><div class="weixin_er" style="display: none;"><img src="/bbs/static/assets/imgs/layout/focus_wx02.png"></div></a></li>
                    <li><a href="http://service.weibo.com/share/share.php?url=http%3A%2F%2Fclub.dffengguang.com.cn&amp;type=icon&amp;language=zh_cn&amp;title=%E4%B8%9C%E9%A3%8E%E9%A3%8E%E5%85%89%E8%B6%85%E7%BA%A7%E9%A3%8E%E8%BF%B7http%3A%2F%2Fclub.dffengguang.com.cn&amp;pic=http%3A%2F%2Fclub.dffengguang.com.cn%2Fbbs%2Fshare.png&amp;searchPic=false&amp;style=simple#_loginLayer_1498302954696" target="_blank"><img src="/bbs/static/assets/imgs/layout/weibo_icon.png" alt="" height="29" style="padding-bottom:2px;"></a></li>
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
            <div class="col-md-2" style="margin-right:-50px;"><a href="http://www.dffengguang.com.cn/index.php/Index/index">首页</a></div>
            <div class="col-md-2" style="width:160px;">
                <a href="#">车型展示</a>
                <ul class="nav">
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/page580">风光580</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/page370">风光370</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/page360">风光360</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/page360b">风光360欧洲柴油版</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/page330">风光330</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <a href="#">购车支持</a>
                <ul class="nav">
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/1">预约试驾</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/2">专营店查询</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/zxgc">在线购车</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/4">天猫旗舰店</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/5">型录索取</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/6">集团购车</a></li>
                </ul>
                </li>
            </div>
            <div class="col-md-2">
                <a href="#">风光动态</a>
                <ul class="nav">
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/1">风光资讯</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/3">活动促销</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/2">媒体声音</a></li>
                </ul>
                </li>
            </div>
            <div class="col-md-2">
                <a href="#">关于东风风光</a>
                <ul class="nav">
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/1">品牌介绍</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/2">精彩视频</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/3">壁纸欣赏</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/4">联系我们</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/5">经销商招募</a></li>
                </ul>
                </li>
            </div>
            <div class="col-md-2">
                <a href="#">售后服务</a>
                <ul class="nav">
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/1">服务承诺</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/2">服务站点查询</a></li>
                    <li><a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/3">售后手册公示</a></li>
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
        $('#logout').on('click',function () {
            $.getJSON('/discuz/logout',function (json) {
                if (json.ret == 0){
                    $.get(json.url,function () {
                        window.location.reload();
                    }).fail(function () {
                        alert('登出失败~');
                    })
                }
            }).fail(function () {
                alert('登出失败~');
            })
            return false;
        });
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
        $('.weixin').on('mouseenter',function () {
            $('.weixin_er').show();
        }).on('mouseleave',function () {
            $('.weixin_er').hide();
        })
    })

</script>
@yield('scripts')
</body>
</html>
