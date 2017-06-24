<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ config('app.name', '') }}</title>

    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="generator" content="Discuz! X3.3" />
    <meta name="author" content="Discuz! Team and Comsenz UI Team" />
    <meta name="copyright" content="2001-2017 Comsenz Inc." />
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

</head>

<body id="nv_portal" class="pg_index" onkeydown="if(event.keyCode==27) return false;">
<div id="append_parent"></div><div id="ajaxwaitid"></div>

<div class="head">
    <div class="head_top">
        <div class="inside">
            <div class="ht_area">
                <p class="loginTop"><a href="/bbs/member.php?mod=logging&amp;action=login&amp;referer=forum.php" onclick="showWindow('login', this.href);return false;" class="xi2">登录</a><a href="/bbs/member.php?mod=register" class="xi2">注册</a></p>
            </div>
        </div>
    </div>
    <div class="head_bottom">
        <div class="inside cl">
            <div class="logo_area cl">
                <a href="/bbs/"><img src="/bbs/static/assets/imgs/layout/logo_1.png" alt=""></a>
                <a href="/bbs/"><img src="/bbs/static/assets/imgs/layout/logo_2.png" alt=""></a>
            </div>
            <div class="search_area cl">
                <div id="scbar" class="cl">
                    <form id="scbar_form" method="post" autocomplete="off" onsubmit="searchFocus($('scbar_txt'))" action="search.php?searchsubmit=yes" target="_blank">
                        <input type="hidden" name="mod" id="scbar_mod" value="forum">
                        <input type="hidden" name="formhash" value="8bfcf00b">
                        <input type="hidden" name="srchtype" value="title">
                        <input type="hidden" name="srhfid" value="">
                        <input type="hidden" name="srhlocality" value="forum::index">
                        <table cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <!-- <td class="scbar_icon_td"></td> -->
                                <td class="scbar_txt_td">
                                    <input type="text" name="srchtxt" id="scbar_txt" value="搜索帖子" autocomplete="off" x-webkit-speech="" speech="" class=" xg1" placeholder="搜索帖子">
                                </td>
                                <!-- <td class="scbar_type_td"><a href="javascript:;" id="scbar_type" class="xg1" onclick="showMenu(this.id)" hidefocus="true">帖子</a></td> -->
                                <td class="scbar_btn_td">
                                    <button type="submit" name="searchsubmit" id="scbar_btn" sc="1" class="pn pnc" value="true"><strong class="xi2">搜索</strong></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div id="nv">
                <div class="btn_area">
                    <ul>
                        <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">车型论坛<span></span></a></li>
                    </ul>
                    <ul>
                        <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">车主聚会<span></span></a></li>
                    </ul>
                    <ul>
                        <li class="a" id="mn_forum"><a href="/mall" hidefocus="true" title="">积分商城<span></span></a></li>
                    </ul>
                    <ul>
                        <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">风光官网<span></span></a></li>
                    </ul>
                </div>
                <div class="share_area">
                    <span>分享至</span>
                    <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/qq_icon.png" alt=""></a>
                    <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/wc_icon.png" alt=""></a>
                    <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/weibo_icon.png" alt=""></a>
                    <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/qzone_icon.png" alt=""></a>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="wp">
    <div class="wrapper">
        <div class="content">
            <div class="inside cl">
                <div class="left">
                    <!-- kv start -->
                    <div id="kv">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($kvs as $kv)
                                <div class="swiper-slide"><img src="{{asset($kv->image)}}" alt="" height="450" width="800"></div>
                                @endforeach
                            </div>
                        </div>
                        <ul class="spic_con">
                            @foreach($kvs as $key=>$kv)
                            <li @if($key == 0)class="on"@endif>
                                    <a href="javascript:;"><img src="{{asset($kv->thumb)}}" width="145" height="100" alt=""></a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- kv end -->
                    <!-- Recommend start -->
                    <div id="recommend" class="contentStyle">
                        <div class="titles">
                            <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/recommend.png" alt=""></a>
                        </div>
                        <div class="contentsWrap">
                            <div id="recommend_hot" class="cl">
                                <div class="left"><img src="/bbs/static/assets/imgs/recommend/recommend_t_pic.jpg" alt=""></div>
                                <div class="right">
                                    <div class="content">
                                        <h2>{{$features[0]->title}}</h2>
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
                                                    <img src="/bbs/static/assets/imgs/recommend/car_pic1.png" alt="">
                                                </div>
                                                <div class="right">
                                                    <h2>{{$feature->title}}</h2>
                                                    <p>{{$feature->description}}</p>
                                                    <div class="userWrap">
                                                        <div class="avatar">
                                                            <img src="{{$feature->avatar}}" alt="">
                                                        </div>
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
                        <div class="menus cl">
                            <ul class="cl">
                                <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">风光580<span></span></a></li>
                                <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">风光370<span></span></a></li>
                                <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">风光330<span></span></a></li>
                                <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">爱车讲堂<span></span></a></li>
                                <li class="a" id="mn_forum"><a href="/bbs/forum.php" hidefocus="true" title="">同城会<span></span></a></li>
                            </ul>
                        </div>
                        <div class="contentsWrap cl">
                            @if(count($hots)>0)
                            <div class="left">
                                <div class="showWrap">
                                    <img src="{{$hots[0]->image}}" alt="">
                                </div>
                                <div class="userWrap">
                                    <div class="top cl">
                                        <div class="avatar">
                                            <img src="{{$hots[0]->avatar}}" alt="">
                                        </div>
                                        <div class="name">
                                            <h3>{{$hots[0]->title}}</h3>
                                            <span>{{$hots[0]->username}}</span>
                                        </div>
                                    </div>
                                    <p>{{$hots[0]->description}}</p>
                                    <div class="icons cl">
                                        <div class="iconsWrap">
                                            <img src="/bbs/static/assets/imgs/recommend/like_pic.png" alt="">
                                            <span>{{$hots[0]->like_num}}</span>
                                        </div>
                                        <div class="iconsWrap">
                                            <img src="/bbs/static/assets/imgs/recommend/share_pic.png" alt="">
                                            <span>{{$hots[0]->share_num}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="right">
                                <ul class="cl">
                                @if(count($hots)>0)
                                @foreach($hots as $k=>$hot)
                                    @if($k > 0)
                                        <li>
                                            <div class="top cl">
                                                <div class="avatar">
                                                    <img src="{{$hot->avatar}}" alt="">
                                                </div>
                                                <div class="name">
                                                    <h3>{{$hot->title}}</h3>
                                                    <span>{{$hot->username}}</span>
                                                </div>
                                            </div>
                                            <p>{{$hot->description}}</p>
                                            <div class="icons cl">
                                                <div class="iconsWrap">
                                                    <img src="/bbs/static/assets/imgs/recommend/like_pic.png" alt="">
                                                    <span>{{$hot->like_num}}</span>
                                                </div>
                                                <div class="iconsWrap">
                                                    <img src="/bbs/static/assets/imgs/recommend/share_pic.png" alt="">
                                                    <span>{{$hot->share_num}}</span>
                                                </div>
                                            </div>
                                        </li>
                                        @endif
                                @endforeach
                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- hotpoint end -->
                </div>
                <div class="right">
                    <!-- login end -->
                    <div id="login">
                        <div class="loginWrap">
                            <h2>账号登陆</h2>
                            <div class="row">
                                <input name="name" type="text" id="name" class="name" value="" placeholder="会员账号/手机号">
                            </div>
                            <div class="row">
                                <input name="password" type="text" id="password" class="password" value="" placeholder="请输入密码">
                            </div>
                            <div class="row remember cl">
                                <div class="checkboxs">
                                    <input id="rm_ck" type="checkbox" checked="checked" />
                                    <label for="rm_ck">记住我</label>
                                </div>
                                <div class="links">
                                    <a href="http://club.dffengguang.com.cn/bbs/member.php?mod=logging&action=login&referer=forum.php">忘记密码</a>
                                </div>
                            </div>
                            <div class="login_b">
                                <!-- <img src="/bbs/static/assets/imgs/login_btn.jpg" alt=""> -->
                                <div class="login_btn_con"><a id="login_btn" href="javascript:;">登陆</a></div>
                                <span>还没有账号？<a href="/bbs/member.php?mod=register">立即注册！</a></span>
                            </div>
                        </div>
                    </div>
                    <!-- login end -->
                    @if(count($right_top_kv)>0)
                        <div class="showWrap">
                            <a href="{{$right_top_kv[0]->link}}"><img src="{{$right_top_kv[0]->image}}" alt="{{$right_top_kv[0]->title}}"></a>
                        </div>
                    @endif
                    <!-- activity start -->
                    <div id="activity" class="contentStyle">
                        <div class="titles">
                            <a href="javascript:;"><img src="/bbs/static/assets/imgs/layout/activity.png" alt=""></a>
                        </div>
                        <div class="content">
                            <ul>
                        @if(count($events) > 0)
                        @foreach($events as $k=>$event)
                            @if($k == 0)
                                <li class="first">
                                    <div class="listWrap">
                                        <div class="showWrap">
                                            <img src="{{$event->image}}" alt="">
                                        </div>
                                        <h2>{{$event->title}}</h2>
                                        <div class="userWrap">
                                            <div class="icons cl">
                                                <div class="iconsWrap">
                                                    <img src="/bbs/static/assets/imgs/recommend/like_pic.png" alt="">
                                                    <span>{{$event->like_num}}</span>
                                                </div>
                                                <div class="iconsWrap">
                                                    <img src="/bbs/static/assets/imgs/recommend/share_pic.png" alt="">
                                                    <span>{{$event->share_num}}</span>
                                                </div>
                                            </div>
                                            <p>{{$event->description}}</p>
                                        </div>

                                    </div>
                                </li>
                            @else
                                <li>
                                    <div class="listWrap">
                                        <div class="left">
                                            <div class="showWrap">
                                                <img src="{{$event->image}}" alt="">
                                            </div>
                                        </div>
                                        <div class="right">
                                            <h3>{{$event->title}}</h3>
                                            <div class="userWrap">
                                                <div class="icons cl">
                                                    <div class="iconsWrap">
                                                        <img src="/bbs/static/assets/imgs/recommend/like_pic.png" alt="">
                                                        <span>{{$event->like_num}}</span>
                                                    </div>
                                                    <div class="iconsWrap">
                                                        <img src="/bbs/static/assets/imgs/recommend/share_pic.png" alt="">
                                                        <span>{{$event->share_num}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                        @endif
                            </ul>
                        </div>
                    </div>
                    <!-- activity end -->
                    @if(count($right_bottom_kv)>0)
                    <div class="showWrap">
                        <a href="{{$right_bottom_kv[0]->link}}"><img src="{{$right_bottom_kv[0]->image}}" alt="{{$right_bottom_kv[0]->title}}"></a>
                    </div>
                    @endif
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


        var mySwiper = new Swiper('.swiper-container', {
            onSlideChangeEnd: function(swiper) {
                _s_pic.eq(swiper.activeIndex).addClass('on');
            },
            onSlideChangeStart: function(swiper) {
                _s_pic.removeClass('on');
            }
        })

        _s_pic.on('click', function(e) {
            var _this = JQ(this);
            spic_index = _this.index();
            mySwiper.slideTo(spic_index);
        });


    });
</script>
</div>  </div>

<div class="footer">
    <div class="footer_cont cl">
        <div class="footer_nav">
            <ul>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/index">首页</a></li>
            </ul>
            <ul>
                <li><span>车型展示</span></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/page580">风光580</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/page370">风光370</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/page360">风光360</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/page360b">风光360欧洲柴油版</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/page330">风光330</a></li>
            </ul>
            <ul>
                <li><span>购车支持</span></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/gczc/type/1">预约试驾</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/gczc/type/2">专营店查询</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/zxgc">在线购车</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/gczc/type/4">天猫旗舰店</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/gczc/type/5">型录索取</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/gczc/type/6">集团购车</a></li>
            </ul>
            <ul>
                <li><span>风光动态</span></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/1">风光资讯</a></li><li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/3">活动促销</a></li><li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/fgdt/newstypeid/2">媒体声音</a></li>      </ul>
            <ul>
                <li><span>关于东风风光</span></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/about/type/1">品牌介绍</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/about/type/2">精彩视频</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/about/type/3">壁纸欣赏</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/about/type/4">联系我们</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/about/type/5">经销商招募</a></li>
            </ul>

            <ul>
                <li><span>售后服务</span></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/shfw/type/1">服务承诺</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/shfw/type/2">服务站点查询</a></li>
                <li><a href="/bbs/http://www.dffengguang.com.cn/index.php/Index/shfw/type/3">售后手册公示</a></li>
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
                <a href="/bbs/http://www.dfmc.com.cn/" target="_blank">东风公司官网</a>
                <a href="/bbs/http://61.184.92.51/StarGPS/Login.aspx" target="_blank">东风小康GPS管理分析系统</a>
                <a href="/bbs/http://dms.dfsk.com.cn/" target="_blank">东风小康商务平台</a>
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
            jQuery.post('/disucz/login', {username:username, password:password},function (json) {
                if (json.ret != 0){
                    alert(json.msg);
                }
                else{
                    jQuery.get(json.url,function () {
                        jQuery('#login').html('');
                    }).fail(function (xhr) {
                        alert('登录失败，请稍候重试。');
                    })
                }
            },"JSON").fail(function (xhr) {
                alert('登录失败，请稍候重试。');
            });
        })
    })
</script>
</body>
</html>
