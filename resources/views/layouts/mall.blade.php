<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.4.6.0.css">
    <link rel="stylesheet" type="text/css" href="/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/css/slick-theme.css">
    <link rel="stylesheet" type="text/css" href="/css/mall.css?_=0.0011">
    <link rel="stylesheet" type="text/css" href="/css/shopcar.css?_=0.011">
    <!-- Jquery -->
    <script src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/slick.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        window.Laravel = {!!json_encode(['csrfToken' => csrf_token(),]) !!};
        $().ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel
                }
            });
        })
    </script>
</head>

<body>
    <div id="login" style="height: 30px;" class="hidden-xs">
        <div class="container">
            <ul class="nav navbar-nav navbar-right">
                @if(!Session::get('discuz.hasLogin'))
                <li class="login">
                    <a href="/bbs/member.php?mod=logging&amp;action=login&amp;referer={{url('/mall')}}">登录</a>
                </li>
                <li class="login">
                    <a href="/bbs/member.php?mod=register">注册</a>
                </li>
                @else
                <li style="padding-left:12px;background: url(/bbs/static/image/common/user_online.gif) no-repeat 0px 10px">
                    <a href="/bbs/home.php?mod=space&amp;uid=1" target="_blank" style="font-weight: bold;" title="访问我的空间">{{Session::get('discuz.user.username')}}</a>
                </li>
                <li class="split">|</li>
                <li>
                    <a href="/bbs/home.php?mod=spacecp">我的</a>
                </li>
                <li class="split">|</li>
                <li>
                    <a href="/mall/order">订单</a>
                </li>
                <li class="split">|</li>
                <li>
                    <a href="/bbs/home.php?mod=spacecp">设置</a>
                </li>
                <li class="split">|</li>
                <li>
                    <a href="/bbs/home.php?mod=space&do=pm">消息</a>
                </li>
                <li>
                    <a href="/bbs/home.php?mod=spacecp&amp;ac=credit4&amp;showcredit=1">风迷币: {{Session::get('discuz.user.user_count.extcredits4')}}</a>
                </li>
                <li>
                    <a href="/bbs/home.php?mod=spacecp&amp;ac=usergroup">用户组: {{Session::get('discuz.user.user_group.grouptitle')}}</a>
                </li>
                <li class="split">|</li>
                <li>
                    <a href="/bbs/home.php?mod=space&amp;do=notice" id="myprompt" class="a showmenu" onmouseover="showMenu({'ctrlid':'myprompt'});">提醒</a>
                </li>
                <li class="split">|</li>
                @if(Session::get('discuz.user.groupid') == 1)
                <li>
                    <a href="/admin">商城管理</a>
                </li>
                <li>
                    <a href="/bbs/admin.php" target="_blank">管理中心</a>
                </li>
                @endif
                <li>
                    <a href="/bbs/member.php?mod=logging&amp;action=logout" id="logout">退出</a>
                </li>
                @endif
            </ul>


        </div>
    </div>
    <header class="navbar navbar-static-top bs-docs-nav" id="top">
        <div class="container">
            <div class="row">
                <div class="pull-right hidden-xs" style="position: absolute;right: 0;">
                    <div class="thread-top" style="">今日:
                        <em>{{session('discuz.forum.todayposts')}}</em>
                        <span class="pipe">|</span>昨日:
                        <em>{{session('discuz.forum.yesterdayposts')}}</em>
                        <span class="pipe">|</span>帖子:
                        <em>{{session('discuz.forum.posts')}}</em>
                        <span class="pipe">|</span>会员:
                        <em>{{session('discuz.user_count')}}</em>
                        <span class="pipe">|</span>欢迎新会员:
                        <a href="/bbs/home.php?mod=space&uid={{session('discuz.latest_user.uid')}}&do=profile">{{session('discuz.latest_user.username')}}</a>
                    </div>
                    <div style="width:285px;margin-top:20px;float:left;">
                        <div class="input-group" id="search">
                            <input type="text" class="form-control" placeholder="搜索帖子" style="outline:none;" />
                            <div class="input-group-btn">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn" style="outline:none;">
                                        <div style="
                                    background: url(http://club.dffengguang.com.cn/bbs/static/assets/imgs/layout/search_icon.png) 0 0 no-repeat;height:20px;width:28px;
                                "></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="topper-01">
                    <a href="http://www.dffengguang.com.cn/" class="hidden-xs">
                        <img src="/bbs/static/assets/imgs/layout/logo_1.png" alt="">
                    </a>
                    <a href="http://club.dffengguang.com.cn/" class="hidden-xs">
                        <img src="/bbs/static/assets/imgs/layout/logo_2.png" alt="">
                    </a>
                </div>
                @if(Request::segment(1) == 'mall')
                <div class="btnShopCar">
                    @if(!session('discuz.hasLogin'))
                    <a href="/bbs/member.php?mod=logging&action=login&referer=http://club.dffengguang.com.cn" class="m-login visible-xs-inline">登录</a>
                    <a href="/bbs/member.php?mod=register" class="m-login visible-xs-inline">注册</a>
                    @else
                    欢迎，{{session('discuz.user.username')}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{ url('/mall/favourite') }}"><img src="{{asset('/images/icon-star.png')}}" alt="" height="14" /> 我的收藏</a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="{{url('/mall/cart')}}">
                        <img src="{{asset('/images/icon-car.png')}}" alt="" height="14" /> 购物车
                        <span id="cart-count">0</span>件&nbsp;&nbsp;&nbsp;&nbsp;></a>
                    @endif
                    
                </div>
                <div class="btnShopCarP hidden-xs" style="display:none;">
                    <ul class="carbox">
                    </ul>
                    <button class="btnBuy">查看购物车</button>
                </div>
                @endif
            </div>
            <div class="row">
                <nav id="bs-navbar" class="collapse navbar-collapse" style="font-weight: bold;">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/">首页</a>
                        </li>
                        <li>
                            <a href="/bbs/forum.php?gid=1">车型论坛</a>
                        </li>
                        <li>
                            <a href="/bbs/forum.php?gid=44">风迷活动</a>
                        </li>
                        <!--<li>
                        <a href="/bbs" >车主聚会</a>
                    </li>-->
                        <li>
                            <a href="/mall">礼品商城</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/" target="_blank">风光官网</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right" style="margin-right:0;">
                        <li>
                            <a href="javascript:;">分享至</a>
                        </li>
                        <li>
                            <a href="javascritp:;" target="_blank" class="weixin">
                                <img src="/bbs/static/assets/imgs/layout/wc_icon.png" height="29" style="padding-bottom:2px;"
                                />
                                <div class="weixin_er" style="display: none;">
                                    <img src="/bbs/static/assets/imgs/layout/focus_wx02.png">
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="http://service.weibo.com/share/share.php?url=http%3A%2F%2Fclub.dffengguang.com.cn&amp;type=icon&amp;language=zh_cn&amp;title=%E4%B8%9C%E9%A3%8E%E9%A3%8E%E5%85%89%E8%B6%85%E7%BA%A7%E9%A3%8E%E8%BF%B7http%3A%2F%2Fclub.dffengguang.com.cn&amp;pic=http%3A%2F%2Fclub.dffengguang.com.cn%2Fbbs%2Fshare.png&amp;searchPic=false&amp;style=simple#_loginLayer_1498302954696"
                                target="_blank">
                                <img src="/bbs/static/assets/imgs/layout/weibo_icon.png" alt="" height="29" style="padding-bottom:2px;">
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    @yield('content')
    <footer class="hidden-xs">
        <div class="container">
            <div class="pull-right" id="footer-services">
                <div class="rows">
                    <h4>24小时关怀热线</h4>
                    <h2>400-887-5551</h2>
                    <p>ICP备案号：渝ICP备16003854号-1</p>
                </div>
            </div>
            <div class="row" id="footer-navbar">
                <div class="col-md-2" style="margin-right:-50px;">
                    <a href="http://www.dffengguang.com.cn/index.php/Index/index">首页</a>
                </div>
                <div class="col-md-2" style="width:160px;">
                    <a href="#">车型展示</a>
                    <ul class="nav">
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/page580">风光580</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/page370">风光370</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/page360">风光360</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/page360b">风光360欧洲柴油版</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/page330">风光330</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <a href="#">购车支持</a>
                    <ul class="nav">
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/1">预约试驾</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/2">专营店查询</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/zxgc">在线购车</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/4">天猫旗舰店</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/5">型录索取</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/6">集团购车</a>
                        </li>
                    </ul>
                    </li>
                </div>
                <div class="col-md-2">
                    <a href="#">风光动态</a>
                    <ul class="nav">
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/1">风光资讯</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/3">活动促销</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/2">媒体声音</a>
                        </li>
                    </ul>
                    </li>
                </div>
                <div class="col-md-2">
                    <a href="#">关于东风风光</a>
                    <ul class="nav">
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/about/type/1">品牌介绍</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/about/type/2">精彩视频</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/about/type/3">壁纸欣赏</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/about/type/4">联系我们</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/about/type/5">经销商招募</a>
                        </li>
                    </ul>
                    </li>
                </div>
                <div class="col-md-2">
                    <a href="#">售后服务</a>
                    <ul class="nav">
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/1">服务承诺</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/2">服务站点查询</a>
                        </li>
                        <li>
                            <a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/3">售后手册公示</a>
                        </li>
                        <li>
                            <a href="http://dfsk.51tis.com/">环保信息</a>
                        </li>
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

    <div class="modal fade " id="modal-login" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">请登录</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => url('/discuz/login'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'login-form')) }}
                    <div class="form-group" id="form-group-username">
                        <label for="username" class="col-md-2 col-xs-4 control-label">用户名:</label>
                        <div class="col-md-10 col-xs-8">
                            <input class="form-control" type="text" value="" name="username">
                            <label class="help-block" for="username" id="help-username"></label>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-password">
                        <label for="price" class="col-md-2 col-xs-4 control-label">密码:</label>
                        <div class="col-md-10 col-xs-8">
                            <input class="form-control" type="password" value="" id="password" name="password">
                            <label class="help-block" for="password" id="help-password"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-xs-8 col-md-offset-4">
                            <button type="submit" class="btn btn-custom">登录</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>

    <div class="modal fade" id="modal-tip" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custom" data-dismiss="modal">确定</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>

    <div class="modal fade" id="modal-address" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">收货人信息</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => url('/mall/address'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'address-form')) }}
                    <div class="form-group" id="form-group-name">
                        <label for="name" class="col-md-2 col-xs-4 control-label">* 收货人:</label>
                        <div class="col-md-10 col-xs-8">
                            <input class="form-control" type="text" value="" id="username" name="name">
                            <label class="help-block" for="name" id="help-name"></label>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-name">
                        <label for="district" class="col-md-2 col-xs-4 control-label">* 地区:</label>
                        <div class="col-md-10 col-xs-8">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <select class="form-control" id="province" name="province">
                                        <option value="">请选择</option>
                                    </select>
                                    <label class="help-block" for="province" id="help-province"></label>
                                </div>
                                <div class="col-lg-4 col-md-4 hidden">
                                    <select class="form-control" id="city" name="city">
                                        <option value="">请选择</option>
                                    </select>
                                    <label class="help-block" for="city" id="help-city"></label>
                                </div>
                                <div class="col-lg-4 col-md-4 hidden">
                                    <select class="form-control" id="district" name="district">
                                        <option value="">请选择</option>
                                    </select>
                                    <label class="help-block" for="district" id="help-district"></label>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group" id="form-group-detail">
                        <label for="detail" class="col-md-2 col-xs-4 control-label">* 详细地址:</label>
                        <div class="col-md-10 col-xs-8">
                            <input class="form-control" type="text" value="" id="detail" name="detail">
                            <label class="help-block" for="detail" id="help-detail"></label>
                        </div>
                    </div>

                    <div class="form-group" id="form-group-mobile">
                        <label for="mobile" class="col-md-2 col-xs-4 control-label">* 手机号码:</label>
                        <div class="col-md-10 col-xs-8">
                            <input class="form-control" type="text" value="" id="mobile" name="mobile">
                            <label class="help-block" for="mobile" id="help-mobile"></label>
                        </div>
                    </div>

                    <div class="form-group" id="form-group-telephone">
                        <label for="telephone" class="col-md-2 col-xs-4 control-label">固定电话:</label>
                        <div class="col-md-10 col-xs-8">
                            <input class="form-control" type="text" value="" id="telephone" name="telephone">
                            <label class="help-block" for="telephone" id="help-telephone"></label>
                        </div>
                    </div>
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <div class="col-md-10 col-xs-8 col-md-offset-2 col-xs-offset-4">
                            <button type="submit" class="btn btn-custom">确 认</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
    <div style="display:none">
        <script type="text/javascript">
            var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
            document.write(unescape("%3Cspan id='cnzz_stat_icon_1264698221'%3E%3C/span%3E%3Cscript src='" +
                cnzz_protocol +
                "s13.cnzz.com/stat.php%3Fid%3D1264698221%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));
        </script>
    </div>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        var mall_districts = {};
        var province_id = null;
        var city_id = null;
        var district_id = null;

        function ajaxCart() {
            $.getJSON('{{url("/mall/ajax/cart")}}', function (json) {
                if (json && json.ret == 0) {
                    var html = '';
                    var count = 0;
                    $.each(json.data, function (index, cart) {
                        count += cart.quantity;
                        html += '<li class="shop">' +
                            '<div class="shopImgmg"><img src="' + cart.item.images[0] +
                            '" width="51" height="51" /> </div>' +
                            '<div class="shopTitle">' + cart.item.name + '</div>' +
                            '<div class="shopBox"></div>' +
                            '<div class="shopJiage">' + cart.item.point + '风迷币 X ' + cart.quantity +
                            '</div>' +
                            '<a class="removeSp" href="javascript:;" data-id="' + cart.id +
                            '">删除</a></li>';
                    });
                    $('#cart-count').text(count);
                    $('.carbox').html(html).find('.removeSp').click(function () {
                        var url = '{{url("/mall/cart")}}/' + $(this).attr('data-id');
                        var obj = $(this).parent();
                        $.ajax(url, {
                            dataType: 'json',
                            type: 'delete',
                            data: {
                                _token: window.Laravel.csrfToken
                            },
                            success: function (json) {
                                if (json.ret == 0) {
                                    if (is_cart) {
                                        window.location.reload();
                                    } else {
                                        obj.remove();
                                    }
                                } else {
                                    alert(json.msg);
                                }
                            },
                            error: function () {
                                alert('请求失败~');
                            }
                        });
                    });;
                }
            });
        }

        function initProvinces(province) {
            var html = '<option value="">请选择</option>';
            $.each(mall_districts, function (index, value) {
                html += '<option value="' + value.name + '" data-id="' + index + '">' + value.name +
                    '</option>'
            })
            $('#province').html(html).parent('div').removeClass('hidden');
            $('#city').html('<option value="">请选择</option>').parent('div').addClass('hidden');
            $('#district').html('<option value="">请选择</option>').parent('div').addClass('hidden');
        }

        function initCities() {
            var html = '<option value="">请选择</option>';
            if (province_id) {
                var _c = mall_districts[province_id].cities;
                if (_c.length > 0) {
                    $.each(_c, function (index, value) {
                        html += '<option value="' + value.name + '" data-id="' + index + '">' + value.name +
                            '</option>'
                    });
                    $('#city').html(html).parent('div').removeClass('hidden');
                }
            } else {
                $('#city').html('<option value="">请选择</option>');
            }
            $('#district').html('<option value="">请选择</option>').parent('div').addClass('hidden');
        }

        function initDistricts() {
            var html = '<option value="">请选择</option>';
            if (province_id && city_id) {
                var _d = mall_districts[province_id].cities[city_id].districts;
                if (_d.length > 0) {
                    $.each(_d, function (index, value) {
                        html += '<option value="' + value.name + '" data-id="' + index + '">' + value.name +
                            '</option>'
                    });
                    $('#district').html(html).parent('div').removeClass('hidden');
                }
            } else {
                $('#district').html('<option value="">请选择</option>');
            }
        }
        @if(Request::url() == url('/mall/cart'))
        var is_cart = true;
        @else
        var is_cart = false;
        @endif
        $().ready(function () {
            $.getJSON('{{url("/districts")}}', function (districts) {
                mall_districts = districts;
                initProvinces();
            });
            $('#province').on('change', function () {
                var element = $(this).find('option:selected');
                province_id = element.attr('data-id');
                initCities();
            });
            $('#city').on('change', function () {
                var element = $(this).find('option:selected');
                city_id = element.attr('data-id');
                initDistricts();
            });
            $('#district').on('change', function () {
                var element = $(this).find('option:selected');
                district_id = element.attr('data-id');
            })
            ajaxCart();
            $('.btnBuy').click(function () {
                window.location.href = '{{url("/mall/cart")}}';
            })
            $('.btnShopCar').mouseover(function (event) {
                $('.btnShopCarP').show();
                $(this).css({
                    "box-shadow": "0px 2px 5px #ccc"
                });
            });
            $(document).click(function (event) {
                $('.btnShopCarP').hide();
                $('.btnShopCar').css({
                    "box-shadow": ""
                });
            });
            $('.btnShopCarP').click(function () {
                return false;
            });
            $('#logout').on('click', function () {
                $.getJSON('/discuz/logout', function (json) {
                    if (json.ret == 0) {
                        $.get(json.url, function () {
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
                success: function (json) {
                    $('.help-block').html('');
                    $('.form-group').removeClass('has-error');
                    if (json.ret == 0) {
                        $.get(json.url, function () {
                            $('#modal-login').modal('hide');
                            window.location.reload();
                        }).fail(function () {
                            $('#help-password').html(
                                '<span class="text-danger">服务器发生错误，请稍候重试。</span>');
                        });
                    } else if (json.ret == 1001) {
                        $('#form-group-username').addClass('has-error');
                        $('#help-username').html(json.msg);
                    } else {
                        $('#form-group-password').addClass('has-error');
                        $('#help-password').html(json.msg);
                    }
                },
                error: function (xhr) {
                    //$('#form-group-password').addClass('has-error');
                    $('#help-password').html('<span class="text-danger">服务器发生错误，请稍候重试。</span>');
                }
            });
            $('#address-form').ajaxForm({
                dataType: 'json',
                success: function (json) {
                    $('.help-block').html('');
                    $('.form-group').removeClass('has-error');
                    if (json.ret == 0) {
                        $('.modal').modal('hide');
                        //$('#modal-tip').find('.modal-body').html(json.msg);
                        //$('#modal-tip').find('.modal-title').html('恭喜');
                        window.location.reload();
                        //$('#modal-tip').modal('show');
                    } else {
                        $('.modal').modal('hide');
                        $('#modal-tip').find('.modal-body').html('<div class="text-center"><h4>抱歉</h4>'+json.msg+'。</div>');
                        $('#modal-tip').find('.modal-title').html('<img src="/images/mall/mobile/icon-warning.png" height="40" />');
                        $('#modal-tip').modal('show');
                    }

                },
                error: function (xhr) {
                    $('.help-block').html('');
                    $('.form-group').removeClass('has-error');
                    var json = jQuery.parseJSON(xhr.responseText);
                    if (xhr.status == 200) {
                        $('#post-form').modal('hide');
                    }
                    $.each(json, function (index, value) {
                        $('#form-group-' + index).addClass('has-error');
                        $('#help-' + index).html(value);
                    });
                }
            });
            $('.weixin').on('mouseenter', function () {
                $('.weixin_er').show();
            }).on('mouseleave', function () {
                $('.weixin_er').hide();
            })
            $.ajax('/points/update', function () {})
        })
    </script>
    @yield('scripts')
</body>

</html>