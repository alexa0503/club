<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
  </div>
<?php if(empty($topic) || ($topic['usefooter'])) { ?>
  <?php $focusid = getfocus_rand($_G[basescript]);?>  <?php if($focusid !== null) { ?>
    <?php $focus = $_G['cache']['focus']['data'][$focusid];?>    <?php $focusnum = count($_G['setting']['focus'][$_G[basescript]]);?>    <div class="focus" id="sitefocus">
      <div class="bm">
        <div class="bm_h cl">
          <a href="javascript:;" onclick="setcookie('nofocus_<?php echo $_G['basescript'];?>', 1, <?php echo $_G['cache']['focus']['cookie'];?>*3600);$('sitefocus').style.display='none'" class="y" title="关闭">关闭</a>
          <h2>
            <?php if($_G['cache']['focus']['title']) { ?><?php echo $_G['cache']['focus']['title'];?><?php } else { ?>站长推荐<?php } ?>
            <span id="focus_ctrl" class="fctrl"><img src="<?php echo IMGDIR;?>/pic_nv_prev.gif" alt="上一条" title="上一条" id="focusprev" class="cur1" onclick="showfocus('prev');" /> <em><span id="focuscur"></span>/<?php echo $focusnum;?></em> <img src="<?php echo IMGDIR;?>/pic_nv_next.gif" alt="下一条" title="下一条" id="focusnext" class="cur1" onclick="showfocus('next')" /></span>
          </h2>
        </div>
        <div class="bm_c" id="focus_con">
        </div>
      </div>
    </div>
    <?php $focusi = 0;?>    <?php if(is_array($_G['setting']['focus'][$_G['basescript']])) foreach($_G['setting']['focus'][$_G['basescript']] as $id) { ?>        <div class="bm_c" style="display: none" id="focus_<?php echo $focusi;?>">
          <dl class="xld cl bbda">
            <dt><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" class="xi2" target="_blank"><?php echo $_G['cache']['focus']['data'][$id]['subject'];?></a></dt>
            <?php if($_G['cache']['focus']['data'][$id]['image']) { ?>
            <dd class="m"><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" target="_blank"><img src="<?php echo $_G['cache']['focus']['data'][$id]['image'];?>" alt="<?php echo $_G['cache']['focus']['data'][$id]['subject'];?>" /></a></dd>
            <?php } ?>
            <dd><?php echo $_G['cache']['focus']['data'][$id]['summary'];?></dd>
          </dl>
          <p class="ptn cl"><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" class="xi2 y" target="_blank">查看 &raquo;</a></p>
        </div>
    <?php $focusi ++;?>    <?php } ?>
    <script type="text/javascript">
      var focusnum = <?php echo $focusnum;?>;
      if(focusnum < 2) {
        $('focus_ctrl').style.display = 'none';
      }
      if(!$('focuscur').innerHTML) {
        var randomnum = parseInt(Math.round(Math.random() * focusnum));
        $('focuscur').innerHTML = Math.max(1, randomnum);
      }
      showfocus();
      var focusautoshow = window.setInterval('showfocus(\'next\', 1);', 5000);
    </script>
  <?php } ?>
  <?php if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && $_G['setting']['showpatchnotice'] == 1) { ?>
    <div class="focus patch" id="patch_notice"></div>
  <?php } ?>

  <?php echo adshow("footerbanner/wp a_f/1");?><?php echo adshow("footerbanner/wp a_f/2");?><?php echo adshow("footerbanner/wp a_f/3");?>  <?php echo adshow("float/a_fl/1");?><?php echo adshow("float/a_fr/2");?>  <?php echo adshow("couplebanner/a_fl a_cb/1");?><?php echo adshow("couplebanner/a_fr a_cb/2");?>  <?php echo adshow("cornerbanner/a_cn");?>  <?php if(!empty($_G['setting']['pluginhooks']['global_footer'])) echo $_G['setting']['pluginhooks']['global_footer'];?>

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
      <div class="logo_b"><img src="static/assets/imgs/layout/logo_footer.png" alt=""></div>
      <div class="share_icons">
        <a href="javascript:;"><img src="static/assets/imgs/layout/icons_wb.png" alt=""></a>
        <a href="javascript:;"><img src="static/assets/imgs/layout/icons_wx.png" alt=""></a>
        <a href="javascript:;"><img src="static/assets/imgs/layout/icons_tx.png" alt=""></a>
      </div>
      <div class="focus_wb">
        <div>
        <wb:follow-button uid="2131542193" type="red_1" width="67" height="24"><iframe src="http://widget.weibo.com/relationship/followbutton.php?btn=red&amp;style=1&amp;uid=2131542193&amp;width=67&amp;height=24&amp;language=zh_cn" width="67" height="24" frameborder="0" scrolling="no" marginheight="0"></iframe></wb:follow-button>
        </div>
      </div>
      <div class="focus_wx"><img src="static/assets/imgs/layout/focus_wx.png" alt=""></div>
    </div>
  </div>
</div>

  <?php updatesession();?>  <?php if($_G['uid'] && $_G['group']['allowinvisible']) { ?>
    <script type="text/javascript">
    var invisiblestatus = '<?php if($_G['session']['invisible']) { ?>隐身<?php } else { ?>在线<?php } ?>';
    var loginstatusobj = $('loginstatusid');
    if(loginstatusobj != undefined && loginstatusobj != null) loginstatusobj.innerHTML = invisiblestatus;
    </script>
  <?php } } if(!$_G['setting']['bbclosed'] && !$_G['member']['freeze'] && !$_G['member']['groupexpiry']) { ?>
  <?php if($_G['uid'] && !isset($_G['cookie']['checkpm'])) { ?>
  <script src="home.php?mod=spacecp&ac=pm&op=checknewpm&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
  <?php } ?>

  <?php if($_G['uid'] && helper_access::check_module('follow') && !isset($_G['cookie']['checkfollow'])) { ?>
  <script src="home.php?mod=spacecp&ac=follow&op=checkfeed&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
  <?php } ?>

  <?php if(!isset($_G['cookie']['sendmail'])) { ?>
  <script src="home.php?mod=misc&ac=sendmail&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
  <?php } ?>

  <?php if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && !isset($_G['cookie']['checkpatch'])) { ?>
  <script src="misc.php?mod=patch&action=checkpatch&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
  <?php } } if($_GET['diy'] == 'yes') { ?>
  <?php if(check_diy_perm($topic) && (empty($do) || $do != 'index')) { ?>
    <script src="<?php echo $_G['setting']['jspath'];?>common_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
    <script src="<?php echo $_G['setting']['jspath'];?>portal_diy<?php if(!check_diy_perm($topic, 'layout')) { ?>_data<?php } ?>.js?<?php echo VERHASH;?>" type="text/javascript"></script>
  <?php } ?>
  <?php if($space['self'] && CURMODULE == 'space' && $do == 'index') { ?>
    <script src="<?php echo $_G['setting']['jspath'];?>common_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
    <script src="<?php echo $_G['setting']['jspath'];?>space_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
  <?php } } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && empty($_G['cookie']['pluginnotice'])) { ?>
  <div class="focus plugin" id="plugin_notice"></div>
  <script type="text/javascript">pluginNotice();</script>
<?php } if(!$_G['setting']['bbclosed'] && !$_G['member']['freeze'] && !$_G['member']['groupexpiry'] && $_G['setting']['disableipnotice'] != 1 && $_G['uid'] && !empty($_G['cookie']['lip'])) { ?>
  <div class="focus plugin" id="ip_notice"></div>
  <script type="text/javascript">ipNotice();</script>
<?php } if($_G['member']['newprompt'] && (empty($_G['cookie']['promptstate_'.$_G['uid']]) || $_G['cookie']['promptstate_'.$_G['uid']] != $_G['member']['newprompt']) && $_GET['do'] != 'notice') { ?>
  <script type="text/javascript">noticeTitle();</script>
<?php } if(($_G['member']['newpm'] || $_G['member']['newprompt']) && empty($_G['cookie']['ignore_notice'])) { ?>
  <script src="<?php echo $_G['setting']['jspath'];?>html5notification.js?<?php echo VERHASH;?>" type="text/javascript"></script>
  <script type="text/javascript">
  var h5n = new Html5notification();
  if(h5n.issupport()) {
    <?php if($_G['member']['newpm'] && $_GET['do'] != 'pm') { ?>
    h5n.shownotification('pm', '<?php echo $_G['siteurl'];?>home.php?mod=space&do=pm', '<?php echo avatar($_G[uid],small,true);?>', '新的短消息', '有新的短消息，快去看看吧');
    <?php } ?>
    <?php if($_G['member']['newprompt'] && $_GET['do'] != 'notice') { ?>
        <?php if(is_array($_G['member']['category_num'])) foreach($_G['member']['category_num'] as $key => $val) { ?>          <?php $noticetitle = lang('template', 'notice_'.$key);?>          h5n.shownotification('notice_<?php echo $key;?>', '<?php echo $_G['siteurl'];?>home.php?mod=space&do=notice&view=<?php echo $key;?>', '<?php echo avatar($_G[uid],small,true);?>', '<?php echo $noticetitle;?> (<?php echo $val;?>)', '有新的提醒，快去看看吧');
        <?php } ?>
    <?php } ?>
  }
  </script>
<?php } userappprompt();?><?php if($_G['basescript'] != 'userapp') { ?>
<div id="scrolltop">
  <?php if($_G['fid'] && $_G['mod'] == 'viewthread') { ?>
  <span><a href="forum.php?mod=post&amp;action=reply&amp;fid=<?php echo $_G['fid'];?>&amp;tid=<?php echo $_G['tid'];?>&amp;extra=<?php echo $_GET['extra'];?>&amp;page=<?php echo $page;?><?php if($_GET['from']) { ?>&amp;from=<?php echo $_GET['from'];?><?php } ?>" onclick="showWindow('reply', this.href)" class="replyfast" title="快速回复"><b>快速回复</b></a></span>
  <?php } ?>
  <span hidefocus="true"><a title="返回顶部" onclick="window.scrollTo('0','0')" class="scrolltopa" ><b>返回顶部</b></a></span>
  <?php if($_G['fid']) { ?>
  <span>
    <?php if($_G['mod'] == 'viewthread') { ?>
    <a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>" hidefocus="true" class="returnlist" title="返回列表"><b>返回列表</b></a>
    <?php } else { ?>
    <a href="forum.php" hidefocus="true" class="returnboard" title="返回版块"><b>返回版块</b></a>
    <?php } ?>
  </span>
  <?php } ?>
</div>
<script type="text/javascript">_attachEvent(window, 'scroll', function () { showTopLink(); });checkBlind();</script>
<?php } if(isset($_G['makehtml'])) { ?>
  <script src="<?php echo $_G['setting']['jspath'];?>html2dynamic.js?<?php echo VERHASH;?>" type="text/javascript"></script>
  <script type="text/javascript">
    var html_lostmodify = <?php echo TIMESTAMP;?>;
    htmlGetUserStatus();
    <?php if(isset($_G['htmlcheckupdate'])) { ?>
    htmlCheckUpdate();
    <?php } ?>
  </script>
<?php } output();?></body>
</html>
