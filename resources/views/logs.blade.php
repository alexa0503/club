
<?xml version="1.0" encoding="utf-8"?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Cache-control" content="no-cache" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
<meta name="format-detection" content="telephone=no" />
<meta name="keywords" content="{{$user->username}}的个人资料" />
<meta name="description" content="{{$user->username}}的个人资料 ,超级风迷东风风光车友会" />
<title>{{$user->username}}的个人资料 -  超级风迷东风风光车友会 -  手机版</title>
<link rel="stylesheet" href="bbs/static/image/mobile/style.css?v=20180424" type="text/css" media="all">
<script src="bbs/static/js/mobile/jquery.min.js??v=20180424" type="text/javascript"></script>


<script src="bbs/static/js/mobile/common.js??v=20180424" type="text/javascript" charset="utf-8"></script>
</head>

<body class="bg">

<!-- header start -->
<header class="header">
    <div class="nav">
<a href="javascript:;" onclick="history.go(-1);" class="z"><img src="bbs/static/image/mobile/images/icon_back.png" /></a>
<span>积分风迷币</span>
    </div>
</header>
<!-- header end -->
<!-- userinfo start -->
<div class="userinfo">
<div class="user_avatar">
<div class="avatar_m"><span><img src="http://club.dffengguang.com.cn/bbs/uc_server/avatar.php?uid={{$uid}}&size=small" /></span></div>
<h2 class="name">{{$user->username}}</h2>
</div>
<div class="user_box" style="margin-bottom:100px;">
<ul>
<li class="active li-point"><div><span>{{$user->point}} </span>评级积分</div></li>
<li class="li-coin"><div><span>{{$user->coin}} </span>风迷币</div></li>
</ul>
<div id="log-point" class="table">
<table>
    <tr>
        <th>操作</th><th>积分变更</th><th>详情</th><th>时间</th>
    </tr>
    @foreach($logs as $log)
    @php $i=0 @endphp
    @if($log->point != 0)
    @php $i++; @endphp
    <tr>
        <td>{{ $log->title }}</td><td>积分<span>{{ $log->point }}</span></td><td>{{ $log->text }}</td><td>{{ date('Y-m-d H:i:s',$log->dateline) }}</td>
    </tr>
    @endif
    @endforeach
    @if($i == 0)
        <tr><td colspan="4">没有记录</td></tr>
    @endif
</table>
</div>
<div id="log-coin" class="table">
<table>
    <tr>
        <th>操作</th><th>风迷币变更</th><th>详情</th><th>时间</th>
    </tr>
    @foreach($logs as $log)
    @php $i=0 @endphp
    @if($log->coin != 0)
    @php $i++; @endphp    
    <tr>
        <td>{{ $log->title }}</td><td>风迷币<span>{{ $log->coin }}</span></td><td>{{ $log->text }}</td><td>{{ date('Y-m-d H:i',$log->dateline) }}</td>
    </tr>
    @endif
    @endforeach
    @if($i == 0)
        <tr><td colspan="4">没有记录</td></tr>
    @endif
</table>
</div>
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
<a href="/bbs/home.php?mod=space&amp;uid=1&amp;do=profile&amp;mycenter=1&amp;mobile=2"><i class="icon-bar icon-profile"></i><span>个人中心</span></a>
</li>
</ul>
</div>
<script>
    $().ready(function(){
        $('#log-point').show();
        $(".li-point").click(function(){
            $('#log-coin').hide();
            $('#log-point').hide();
            $('#log-point').show();
            $(".li-coin").removeClass('active')
            $(".li-point").addClass('active')
        })
        $(".li-coin").click(function(){
            $('#log-coin').hide();
            $('#log-point').hide();
            $('#log-coin').show();
            $(".li-coin").addClass('active')
            $(".li-point").removeClass('active')
        })
    })
</script>
</body>
</html>