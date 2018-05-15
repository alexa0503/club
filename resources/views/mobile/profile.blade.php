<?xml version="1.0" encoding="utf-8"?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="no-cache" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="admin的个人资料" />
<meta name="description" content="admin的个人资料 ,超级风迷东风风光车友会" />
<title>admin的个人资料 -  超级风迷东风风光车友会 -  手机版 - Powered by Discuz!</title>
<link rel="stylesheet" href="/bbs/static/image/mobile/style.css" type="text/css" media="all">
<script src="/bbs/static/js/mobile/jquery.min.js?O2Q" type="text/javascript"></script>
<script src="/bbs/static/js/mobile/common.js?O2Q" type="text/javascript" charset="utf-8"></script>
</head>

<body class="bg">

<!-- header start -->
<header class="header">
<div class="hdc cl">
<h2><a title="超级风迷东风风光车友会" href="forum.php?mobile=2"><img src="/bbs/static/image/mobile/images/logo.png" /></a></h2>

</div>
</header>
<!-- header end -->
<!-- userinfo start -->
<div class="userinfo">
<div class="user_avatar">
<div class="avatar_m"><span><img src="{{ session('discuz.user.avatar') }}" /></span></div>
<h2 class="name">{{ session('discuz.user.username') }}</h2>
<div><span style="background:#fff;padding:4px 6px;">评级积分：{{ session('discuz.user.user_count.extcredits1') }} &nbsp;&nbsp;&nbsp;风迷币：{{ session('discuz.user.user_count.extcredits4') }}</span></div>
</div>
<div class="myinfo_list cl">
<ul>
<li><a href="home.php?mod=space&amp;uid=1&amp;do=favorite&amp;view=me&amp;type=thread&amp;mobile=2">我的收藏</a></li>
<li><a href="home.php?mod=space&amp;uid=1&amp;do=thread&amp;view=me&amp;mobile=2">我的主题</a></li>
<li class="tit_msg"><a href="home.php?mod=space&amp;do=pm&amp;mobile=2">我的消息</a></li>
<li><a href="/logs">积分风迷币</a></li>
      <li><a href="/verify">车主认证</a></li>
      <li><a href="/mall/order">我的订单</a></li>
      <li><a href="/bbs/home.php?mod=spacecp&ac=credit&op=rule&forcemobile=1">积分规则</a></li>
      <li><a href="/bbs/home.php?mod=spacecp&ac=credit4&op=rule">风迷币规则</a></li>
</ul>
</div>
</div>
<!-- userinfo end -->


<div id="mask" style="display:none;"></div>
<div class="car-bar">
<ul class="nav nav-pills">
<li>
<a href="/mall"><i class="icon-bar icon-cart"></i><span>礼品兑换</span></a>
</li>
<li class="">
<a href="/bbs/forum.php?gid=44"><i class="icon-bar icon-activity"></i><span>风迷社区</span></a>
</li>
<li class="active">
<a href="/profile"><i class="icon-bar icon-profile"></i><span>会员信息</span></a>
</li>
</ul>
</div>
</body>
</html>