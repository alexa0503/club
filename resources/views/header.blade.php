<div class="head">
    <div class="head_top">
        <div class="inside">
            <div class="ht_area">
                @if(!Session::get('discuz.hasLogin'))
                    <p class="loginTop"><a href="/bbs/member.php?mod=logging&amp;action=login&amp;referer={{url('/')}}" onclick="showWindow('login', this.href);return false;" class="xi2">登录</a><a href="/bbs/member.php?mod=register" class="xi2">注册</a></p>
                @else
                    <div id="um">
                        <p>
                            <strong class="vwmy"><a href="/bbs/home.php?mod=space&amp;uid=1" target="_blank" title="访问我的空间">{{Session::get('discuz.user.username')}}</a></strong>
                            <span class="pipe">|</span><a href="/bbs/home.php?mod=spacecp" id="myitem"  >我的</a>
                            <a href="/bbs/home.php?mod=spacecp&amp;ac=credit4&amp;showcredit=1" id="extcreditmenu">风迷币: {{Session::get('discuz.user.user_count.extcredits4')}}</a>
                            <span class="pipe">|</span><a href="/bbs/home.php?mod=spacecp&amp;ac=usergroup" id="g_upmine" >用户组: {{Session::get('discuz.user.user_group.grouptitle')}}</a>


                            <span class="pipe">|</span><a href="/bbs/home.php?mod=space&amp;do=notice" id="myprompt" class="a showmenu" onmouseover="showMenu({'ctrlid':'myprompt'});">提醒</a><span id="myprompt_check"></span>
                            @if(Session::get('discuz.user.groupid') == 1)
                                <span class="pipe">|</span><a href="/admin">商城管理</a>
                                <span class="pipe">|</span><a href="/bbs/admin.php" target="_blank">管理中心</a>
                            @endif
                            <span class="pipe">|</span><a href="/bbs/member.php?mod=logging&amp;action=logout&amp;referer=" id="discuz-logout">退出</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="head_bottom">
        <div class="inside cl">
            <div class="logo_area cl">
                <a href="http://www.dffengguang.com.cn/"><img src="/bbs/static/assets/imgs/layout/logo_1.png" alt=""></a>
                <a href="http://club.dffengguang.com.cn/"><img src="/bbs/static/assets/imgs/layout/logo_2.png" alt=""></a>
            </div>
            <div class="search_area cl">
                <div style="float:left;margin-top: 20px;line-height: 40px;height: 40px;margin-right:10px;"><p class="chart">今日: <em>{{session('discuz.forum.todayposts')}}</em><span class="pipe">|</span>昨日: <em>{{session('discuz.forum.yesterdayposts')}}</em><span class="pipe">|</span>帖子: <em>{{session('discuz.forum.posts')}}</em><span class="pipe">|</span>会员: <em>{{session('discuz.user_count')}}</em><span class="pipe">|</span>欢迎新会员: <a href="/bbs/home.php?mod=space&uid={{session('discuz.latest_user.uid')}}&do=profile" class="xi2">{{session('discuz.latest_user.username')}}</a></p></div>
                <div id="scbar" class="cl" style="float:left;">
                    <form id="scbar_form" method="get" autocomplete="off" onsubmit="searchFocus($('scbar_txt'))" action="/bbs/search.php?mod=portal&searchid=3&searchsubmit=yes&kw=" target="_blank">
                        <table cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <!-- <td class="scbar_icon_td"></td> -->
                                <td class="scbar_txt_td">
                                    <input type="text" name="kw" id="scbar_txt" value="搜索帖子" autocomplete="off" x-webkit-speech="" speech="" class=" xg1" placeholder="搜索帖子">
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
                        <li class="a" id="mn_forum"><a href="/" hidefocus="true" title="">首页<span></span></a></li>
                    </ul>
                    <ul>
                        <li class="a" id="mn_forum"><a href="/bbs/forum.php?gid=1" hidefocus="true" title="">车型论坛<span></span></a></li>
                    </ul>
                    <ul>
                        <li class="a" id="mn_forum"><a href="/bbs/forum.php?gid=44" hidefocus="true" title="">风迷活动<span></span></a></li>
                    </ul>
                    <ul>
                        <li class="a" id="mn_forum"><a href="/mall" hidefocus="true" title="">积分商城<span></span></a></li>
                    </ul>
                    <ul>
                        <li class="a" id="mn_forum"><a href="http://dffengguang.com.cn/" hidefocus="true" title="" target="_blank">风光官网<span></span></a></li>
                    </ul>
                </div>
                <div class="share_area">
                    <span>分享至</span>
                    <a href="javascript:;" class="weixin"><img src="/bbs/static/assets/imgs/layout/wc_icon.png" alt=""></a>
                    <a href="http://service.weibo.com/share/share.php?url=http%3A%2F%2Fclub.dffengguang.com.cn&amp;type=icon&amp;language=zh_cn&amp;title=%E4%B8%9C%E9%A3%8E%E9%A3%8E%E5%85%89%E8%B6%85%E7%BA%A7%E9%A3%8E%E8%BF%B7http%3A%2F%2Fclub.dffengguang.com.cn&amp;pic=http%3A%2F%2Fclub.dffengguang.com.cn%2Fbbs%2Fshare.png&amp;searchPic=false&amp;style=simple#_loginLayer_1498302954696" target="_blank"><img src="/bbs/static/assets/imgs/layout/weibo_icon.png" alt=""></a>
                </div>
            </div>
            <div class="weixin_er" style="display: none;"><img src="/bbs/static/assets/imgs/layout/focus_wx02.png"></div>
        </div>
    </div>
</div>
