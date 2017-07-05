<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name', '') }}</title>
    <meta name="MSSmartTagsPreventParsing" content="True" />
    <meta http-equiv="MSThemeCompatible" content="Yes" />
    <link rel="stylesheet" type="text/css" href="/bbs/data/cache/style_1_common.css?Pxk" />
    <script>
        SITEURL = '{{url("/")}}';
        charset = 'UTF-8';
    </script>
    <script src="/bbs/static/js/common.js?Pxk" type="text/javascript"></script>
    <meta name="application-name" content="超级风迷东风风光车友会" />
    <meta name="msapplication-tooltip" content="超级风迷东风风光车友会" />
    <meta name="msapplication-task" content="name=车型论坛;action-uri=http://club.himyweb.com/bbs/forum.php;icon-uri=http://club.himyweb.com/bbs/static/image/common/bbs.ico" />
    <script src="/bbs/static/js/portal.js?Pxk" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/bbs/static/assets/css/screen.min.css">
    <link rel="stylesheet" type="text/css" href="/bbs/static/assets/css/swiper-3.4.1.min.css">
    <link rel="stylesheet" type="text/css" href="/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/css/slick-theme.css">
    <style type="text/css">
        #login-after {
            height: 374px;
            background: url({{asset('/images/bkg-index-login.jpg')}}) 0 0 no-repeat #f9f8f8;
            margin-bottom: 25px;
            text-align: center;
        }
        #login-after .avatar {
            padding-top:160px;
        }
        #login-after .avatar img{
            border-radius:50%
        }
        #login-after .title {
            padding-top: 5px;
            padding-bottom: 5px;
            line-height: 36px;
            font-size:16px;
            font-weight: bold;
            color: #000;
        }
        #login-after .text1 {
            line-height:20px;
            font-size: 12px;
            color: #828282;
            padding-bottom: 10px;
        }
        #login-after .text2 {
            line-height:16px;
            font-size: 11px;
            color: #828282;
        }
        #login-after .text2 .split {
            margin: 0px 20px;
        }
        #login-after .icon {
            display: inline-block;
            font-style: normal;
            font-weight: 400;
            height: 25px;
            line-height: 1;
            position: relative;
            top: 6px;
            width: 25px;
        }
        #login-after .icon-medal-10 {
            background: rgba(0, 0, 0, 0) url("{{asset('/bbs/static/assets/imgs/layout/icon-medal-01.png')}}") no-repeat scroll 0 0 / contain;
            left:10px;
        }
        #login-after .icon-medal-11 {
            background: rgba(0, 0, 0, 0) url("{{asset('/bbs/static/assets/imgs/layout/icon-medal-02.png')}}") no-repeat scroll 0 0 / contain;
            left:10px;
        }
        #login-after .icon-medal-12 {
            background: rgba(0, 0, 0, 0) url("{{asset('/bbs/static/assets/imgs/layout/icon-medal-03.png')}}") no-repeat scroll 0 0 / contain;
            left:10px;
        }
        #login-after .icon-medal-13 {
            background: rgba(0, 0, 0, 0) url("{{asset('/bbs/static/assets/imgs/layout/icon-medal-04.png')}}") no-repeat scroll 0 0 / contain;
            left:10px;
        }
        #login-after .icon-medal-14 {
            background: rgba(0, 0, 0, 0) url("{{asset('/bbs/static/assets/imgs/layout/icon-medal-05.png')}}") no-repeat scroll 0 0 / contain;
            left:10px;
        }
        #login-after .icon-verify-01 {
            background: rgba(0, 0, 0, 0) url("{{asset('/bbs/static/assets/imgs/layout/icon-verify-01.png')}}") no-repeat scroll 0 0 / contain;
            width: 19px;
            height: 19px;
            top:5px;
            right:8px;
        }
        #login-after .icon-verify-02 {
            background: rgba(0, 0, 0, 0) url("{{asset('/bbs/static/assets/imgs/layout/icon-verify-02.png')}}") no-repeat scroll 0 0 / contain;
            width: 19px;
            height: 19px;
            top:5px;
            right:8px;
        }
        #login-after .verify-01 {
            background: #cc412e;
            color: #fff;
            padding: 0 10px;
            margin-left: 18px;
        }
        .digest {
            padding:20px 26px 0;
        }
        .digest ul li {
            line-height: 20px;
            height: 20px;
            padding: 10px 0;
            position: relative;
        }
        .digest ul li:last-child {
            border-bottom: none;
        }
        .digest ul li a {
            font-size: 14px;
            font-weight: bold;
        }
        .digest ul li i {
            margin-left: 34px;
        }
        .digest ul li span {
            position: absolute;
            right: 0;
        }
        .digest table {
            width: 100%;
            color: #000;
        }
        .digest table tr td {
            height: 40px;
        }
        .digest table tr td.forumtitle{
            font-weight: bold;
            font-size: 14px;
        }
        .digest table tr td.username {
            width: 80px;
        }
        .digest table tr td.forumname {
            width: 60px;
        }
        .digest table tr td.dateline {
            width: 160px;
        }
        .digest a:hover {
            text-decoration: underline!important;
        }
        .digest i {
            color: #858585;
        }
        #boards {
            background: #FFF;
            padding-bottom: 10px;
        }
        #boards .tab ul {
            height: 40px;
            width: 100%;
            list-style: none;
        }
        #boards .tab ul li {
            float: left;
            width: 50%;
            margin: 0;
        }
        #boards .tab ul li a {
            display: block;
            width: 100%;
            height: 40px;
            font-weight: bold;
            font-size: 14px;
            line-height: 40px;
            text-align: center;
            background: #000;
            color: #ffffff;
        }
        #boards .tab ul li a:hover,#boards .tab ul li a.active {
            background: darkred;
        }
        #boards .content {
            margin: 5px 5px;
        }
        #boards .content table {
            width: 100%;
        }
        #boards .content table:last-child{
            display: none;
        }
        #boards .content table tr td {
            height: 40px;
            vertical-align: middle;
        }
        #boards .content table tr td.order {
            width: 36px;
        }
        #boards .content table tr td.order i {
            background: red;
            color: #ffffff;
            padding: 2px 8px;
        }
        #boards .content table tr td.order i.no-bg {
            background: #fff;
            color: #000;
        }
        #boards .content table tr td.avatar {
            width: 48px;
        }
        #boards .content table tr td.avatar img {
            width: 32px;
            height: 32px;
        }
        #boards .content table tr td.username {
            width: 120px;
        }
        #boards .content table tr td.number {

        }

    </style>

</head>

<body id="nv_portal" class="pg_index" onkeydown="if(event.keyCode==27) return false;">
<div id="append_parent"></div><div id="ajaxwaitid"></div>

@include('header')
<div class="wp">
    <div class="wrapper">
        <div class="content">
            <div class="inside cl">
                <div class="left">
                    <!-- kv start -->
                    <div id="kv" style="height: 450px;">
                        <div class="slick">
                            @foreach($kvs as $kv)
                                <div class="swiper-slide"><a href="{{$kv->link}}"><img src="{{asset($kv->image)}}" alt="" height="450" width="800"></a></div>
                            @endforeach
                        </div>
                    </div>
                    <!-- kv end -->
                    <!-- Recommend start -->
                    <div id="recommend" class="contentStyle">
                        <div class="titles">
                            <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/recommend.png" alt=""></a>
                        </div>
                        <div class="contentsWrap">
                            <div id="recommend_hot" class="cl">
                                <div class="left"><a href="{{$features[0]->link}}"><img src="{{$features[0]->image}}" alt=""></a></div>
                                <div class="right">
                                    <div class="content">
                                        <h2><a href="{{$features[0]->link}}" title="{{$features[0]->title}}">{{ $features[0]->title}}</a></h2>
                                        <p>{!! $features[0]->description !!}</p>
                                    </div>
                                    <div class="userWrap">
                                        <div class="avatar">
                                            <img width="39" height="39" src="{{$features[0]->avatar}}" alt="">
                                        </div>
                                        <div class="name">
                                            <span>{{$features[0]->username}}</span>
                                        </div>
                                        <div class="iconsWrap">
                                            <img src="/bbs/static/assets/imgs/recommend/like_pic.png" alt="">
                                            <span>{{$features[0]->like_num}}</span>
                                        </div>
                                        <div class="iconsWrap">
                                            <img src="/bbs/static/assets/imgs/recommend/share_pic.png" alt="">
                                            <span>{{$features[0]->share_num}}</span>
                                        </div>
                                    </div>
                                    <div class="linksBtn">
                                        <a href="{{$features[0]->link}}">查看详情</a>
                                    </div>
                                </div>
                            </div>
                            <div id="recommend_content" class="cl">
                                <ul>
                                    @foreach($features as $k=>$feature)
                                        @if($k>0)
                                            <li>
                                                <div class="left">
                                                    <a href="{{$feature->link}}"><img src="{{$feature->avatar}}" alt="" width="48" height="48"></a>
                                                </div>
                                                <div class="right">
                                                    <h2><a href="{{$feature->link}}" title="{{$feature->title}}">{{ str_limit($feature->title,40,'…')}}</a></h2>
                                                    <div class="userWrap">
                                                        <div class="name">
                                                            <span>{{$feature->username}}</span>
                                                        </div>
                                                        <div class="iconsWrap">
                                                            <img src="/bbs/static/assets/imgs/recommend/like_pic.png" alt="">
                                                            <span>{{$feature->like_num}}</span>
                                                        </div>
                                                        <div class="iconsWrap">
                                                            <img src="/bbs/static/assets/imgs/recommend/share_pic.png" alt="">
                                                            <span>{{$feature->share_num}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Recommend end -->
                    <!-- hotpoint start -->
                    <div id="hotpoint" class="contentStyle">
                        <div class="titles">
                            <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/hotpoint.png" alt=""></a>
                        </div>
                        <div class="menus">
                            <ul>
                                <li><a data-target="digest-digest" href="javascript:;" class="active">最新精华</a></li>
                                <li><a data-target="digest-hotreply" href="javascript:;">热门回复</a></li>
                            </ul>
                        </div>
                        <div style="width:100%;overflow: hidden;height: 516px;">
                            @foreach($forums as $k=>$forum)
                                <div id="digest-{{$k}}" class="digest" {!! $k!='digest'?' style="display: none;"':'' !!}>
                                    <table>
                                        <tbody>
                                        @foreach($forum as $thread)
                                        <tr>
                                            <td class="forumtitle"><a href="/bbs/forum.php?mod=viewthread&tid={{$thread->tid}}&fromuid={{$thread->fid}}" title="{{$thread->subject}}">{{ str_limit($thread->subject,60,'…')}}</td>
                                            <td class="username"><a href="/bbs/home.php?mod=space&uid={{$thread->authorid}}">{{$thread->author}}</a></td>
                                            <td class="forumname"><a href="/bbs/forum.php?mod=forumdisplay&fid={{$thread->fid}}">{{$thread->name}}</a></td>
                                            <td class="dateline">@if($k=='hotreply')最新回复: <i>{{\App\Helpers\DiscuzHelper::formatTime($thread->lastpost,'m/d H:i')}}</i>@else发布时间: <i>{{\App\Helpers\DiscuzHelper::formatTime($thread->dateline)}}</i>@endif</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <!-- hotpoint end -->
                </div>
                <div class="right">
                    @if(!session('discuz.hasLogin'))
                        <div id="login">
                            <div class="loginWrap" style="height: 310px;">
                                <h2>账号登录</h2>
                                <div class="row">
                                    <input name="name" type="text" id="name" class="name" value="" placeholder="会员账号/手机号">
                                </div>
                                <div class="row">
                                    <input name="password" type="password" id="password" class="password" value="" placeholder="请输入密码">
                                </div>
                                <div class="row remember cl">
                                    <div class="checkboxs">
                                        <input id="rm_ck" type="checkbox" checked="checked" />
                                        <label for="rm_ck">记住我</label>
                                    </div>
                                    <div class="links">
                                        <a href="/bbs/member.php?mod=logging&action=login&referer=forum.php">忘记密码</a>
                                    </div>
                                </div>
                                <div class="login_b">
                                    <!-- <img src="/bbs/static/assets/imgs/login_btn.jpg" alt=""> -->
                                    <div class="login_btn_con"><a id="login_btn" href="javascript:;">登录</a></div>
                                    <span>还没有账号？<a href="/bbs/member.php?mod=register">立即注册！</a></span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="login-after">
                            <div class="avatar">
                                <a href="{{url('/bbs/home.php?mod=spacecp&ac=profile')}}"><img src="{{session('discuz.user.avatar')}}" width="108" height="108"></a>
                            </div>
                            <div class="title" title="用户组:{{session('discuz.user.user_group.grouptitle')}}">用户名：{{session('discuz.user.username')}}@if(session('discuz.user.user_group.groupid')>9)<i class="icon icon-medal-{{session('discuz.user.user_group.groupid')}}"></i>@endif</div>
                            <div class="text1">
                            @if(session('discuz.user.hasVerified'))
                                <i class="icon icon-verify-02"></i>认证车主
                            @else
                                <i class="icon icon-verify-01"></i>普通用户
                                <a href="/bbs/home.php?mod=spacecp&ac=profile&op=verify" class="verify-01">申请车主认证</a>
                            @endif
                            </div>
                            <div class="text2">
                                积分：{{session('discuz.user.user_count.extcredits1')}}<span class="split">|</span>风迷币：{{session('discuz.user.user_count.extcredits4')}}
                            </div>


                        </div>
                    @endif
                <!-- login end -->
                    <div class="showWrap" id="boards">
                        <div class="tab">
                            <ul>
                                <li><a class="active" href="javascrit:;" data-target="boards-digest">精华风迷</a></li>
                                <li><a href="javascrit:;" data-target="boards-diligent">勤奋风迷</a></li>
                            </ul>
                        </div>
                        <div class="content">
                            @foreach($members as $k=>$member)
                            <table id="boards-{{$k}}">
                                <tbody>
                                @if(count($member)>0)
                                @foreach($member as $n=>$v)
                                <tr>
                                    <td class="order"><i{!! $n>=3?' class="no-bg"':'' !!}>{{$n+1}}</i></td>
                                    <td class="avatar"><a href="/bbs/home.php?mod=space&uid={{$v->uid}}"><img src="/bbs/uc_server/avatar.php?uid={{$v->uid}}&size=middle&_={{time()}}" width="30" height="30"/></a> </td>
                                    <td class="username"><a href="/bbs/home.php?mod=space&uid={{$v->uid}}">{{$v->username}}</a></td>
                                    <td class="number">{{$k=='digest'?$v->digestposts:$v->posts}}帖</td>
                                </tr>
                                @endforeach
                                @endif
                                </tbody>
                            </table>
                            @endforeach
                        </div>
                    </div>
                <!-- activity start -->
                    <div id="activity" class="contentStyle" style="height:885px;">
                        <div class="titles">
                            <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/activity.png" alt=""></a>
                        </div>
                        <div class="content">
                            <ul>
                                @if(count($events) > 0)
                                    @foreach($events as $k=>$event)
                                        @if($k < 3)
                                            <li>
                                                <div class="listWrap">
                                                    <a href="{{$event->link}}"><img src="{{$event->image}}" alt="" width="260" height="160"></a>
                                                    <h2><a href="{{$event->link}}" title="{{$event->title}}">{{ $event->title }}</a></h2>
                                                    <p>{!! $event->description !!}</p>

                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                    <!-- activity end -->
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/bbs/misc.php?mod=diyhelp&action=get&type=index&diy=yes&r=pN7h" type="text/javascript" type="text/javascript"></script>

<script src="/bbs/static/assets/js/public/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="/bbs/static/assets/js/public/swiper-3.4.0.jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var JQ = jQuery.noConflict();

    JQ(function() {
        // 底部关注的弹出
        var _share_icons = JQ('.share_icons'),
            _focus_wb = JQ('.focus_wb'),
            _focus_wx = JQ('.focus_wx');

        var _quick_links = JQ('.quick_links'),
            _quick_links_con = _quick_links.find('dd');

        var spic_index, _spic_con = JQ('.spic_con'),
            _s_pic = _spic_con.find('li');

        _share_icons.on('mouseover', 'a', function(e) {
            var _this = JQ(this);
            var index = _this.index();

            if (index == 0) {
                _focus_wb.show();
                _focus_wx.hide();

            } else if (index == 1) {
                _focus_wb.hide();
                _focus_wx.show();
            }
        });

        JQ(document).on('click', function() {
            _focus_wx.hide();
            _focus_wb.hide();
        });

        // 底部点击出现
        _quick_links.on('click', function() {
            _quick_links_con.slideToggle();
        });

    });
</script>
</div>  </div>

<div class="footer">
    <div class="footer_cont cl">
        <div class="footer_nav">
            <ul>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/index">首页</a></li>
            </ul>
            <ul>
                <li><span>车型展示</span></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/page580">风光580</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/page370">风光370</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/page360">风光360</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/page360b">风光360欧洲柴油版</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/page330">风光330</a></li>
            </ul>
            <ul>
                <li><span>购车支持</span></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/1">预约试驾</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/2">专营店查询</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/zxgc">在线购车</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/4">天猫旗舰店</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/5">型录索取</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/gczc/type/6">集团购车</a></li>
            </ul>
            <ul>
                <li><span>风光动态</span></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/1">风光资讯</a></li><li><a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/3">活动促销</a></li><li><a href="http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/2">媒体声音</a></li>      </ul>
            <ul>
                <li><span>关于东风风光</span></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/1">品牌介绍</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/2">精彩视频</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/3">壁纸欣赏</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/4">联系我们</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/about/type/5">经销商招募</a></li>
            </ul>

            <ul>
                <li><span>售后服务</span></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/1">服务承诺</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/2">服务站点查询</a></li>
                <li><a href="http://www.dffengguang.com.cn/index.php/Index/shfw/type/3">售后手册公示</a></li>
            </ul>
        </div>
        <div class="footer_tel">
            <p>24小时关怀热线</p>
            <h2>400-887-5551</h2>
            <p>ICP备案号：渝ICP备16003854号-1</p>
        </div>
        <dl class="quick_links">
            <dt>企业快速链接</dt>
            <dd>
                <a href="http://www.dfmc.com.cn/" target="_blank">东风公司官网</a>
                <a href="http://61.184.92.51/StarGPS/Login.aspx" target="_blank">东风小康GPS管理分析系统</a>
                <a href="http://dms.dfsk.com.cn/" target="_blank">东风小康商务平台</a>
            </dd>
        </dl>

        <div class="footer_share">
            <div class="logo_b"><img src="/bbs/static/assets/imgs/layout/logo_footer.png" alt=""></div>
            <div class="share_icons">
                <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/icons_wb.png" alt=""></a>
                <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/icons_wx.png" alt=""></a>
                <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/icons_tx.png" alt=""></a>
            </div>
            <div class="focus_wb">
                <div>
                    <wb:follow-button uid="2131542193" type="red_1" width="67" height="24"><iframe src="http://widget.weibo.com/relationship/followbutton.php?btn=red&amp;style=1&amp;uid=2131542193&amp;width=67&amp;height=24&amp;language=zh_cn" width="67" height="24" frameborder="0" scrolling="no" marginheight="0"></iframe></wb:follow-button>
                </div>
            </div>
            <div class="focus_wx"><img src="/bbs/static/assets/imgs/layout/focus_wx.png" alt=""></div>
        </div>
    </div>
</div>




<div id="scrolltop">
    <span hidefocus="true"><a title="返回顶部" onclick="window.scrollTo('0','0')" class="scrolltopa" ><b>返回顶部</b></a></span>
</div>
<script type="text/javascript">_attachEvent(window, 'scroll', function () { showTopLink(); });checkBlind();</script>
<div id="discuz_tips" style="display:none;"></div>
<script type="text/javascript">
    var tipsinfo = '62588428|X3.3|0.6||0||0|7|1498142327|99f2ee96e705e716658714150ea443bf|2';
</script>
<script src="http://discuz.gtimg.cn/cloud/scripts/discuz_tips.js?v=1" type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript">
    jQuery(function () {
        jQuery('#login_btn').on('click',function () {
            var username = jQuery('#name').val();
            var password = jQuery('#password').val();
            var _token = '{{csrf_token()}}';
            jQuery.post('/discuz/login', {username:username, password:password,_token:_token},function (json) {
                if (json.ret != 0){
                    alert(json.msg);
                }
                else{
                    jQuery.get(json.url,function () {
                        window.location.reload();
                        //jQuery('#login').remove();
                    }).fail(function (xhr) {
                        alert('登录失败，请稍候重试。');
                    })
                }
            },"JSON").fail(function (xhr) {
                alert('登录失败，请稍候重试。');
            });
        })
        jQuery('#discuz-logout').on('click',function () {
            jQuery.getJSON('/discuz/logout',function (json) {
                if (json.ret == 0){
                    jQuery.get(json.url,function () {
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
        var _weixin = JQ('.weixin');
        var _weixinR = JQ('.weixin_er');
        _weixin.on('mouseenter mouseleave',function(e){
            if( e.type =="mouseenter" ){
                _weixinR.show();
            }
            if( e.type =="mouseleave" ){
                _weixinR.hide();
            }
        });
    })
</script>
<script src="/js/slick.js"></script>
<script>
    jQuery(function () {
        jQuery('.slick').slick({
            'prevArrow':null,
            'nextArrow':null,
            'dots':true,
            'autoplay':true
        });
        jQuery('.menus ul li a').click(function () {
            jQuery('.menus ul li a').removeClass('active');
            jQuery(this).addClass('active');
            var id = jQuery(this).attr('data-target');
            jQuery('.digest').hide();
            jQuery('#'+id).show();
        })
        jQuery('#boards .tab ul li a').click(function () {
            jQuery('#boards .tab ul li a').removeClass('active');
            jQuery(this).addClass('active');
            var id = jQuery(this).attr('data-target');
            jQuery('#boards .content table').hide();
            jQuery('#'+id).show();
        })
    })
</script>
</body>
</html>
