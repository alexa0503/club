<div class="car-bar">
        <ul class="nav nav-pills">
            <li class="{{ $active == 'mall' ? 'active':'' }}">
                <a href="/mall"><img src="/images/mall/mobile/icon-car.png" width="30" /><span>积分商城</span></a>
            </li>
            <li class="{{ $active == 'activity' ? 'active':'' }}">
                <a href="/bbs/forum.php?gid=44"><img src="/images/mall/mobile/icon-activity.png" width="30" /><span>最新活动</span></a>
            </li>
            <li class="{{ $active == 'club' ? 'active':'' }}">
                <a href="/bbs/forum.php"><img src="/images/mall/mobile/icon-club.png" width="30" /><span>风迷社区</span></a>
            </li>
            <li class="{{ $active == 'profile' ? 'active':'' }}">
                <a href="/bbs/home.php?mod=space&uid=1&do=profile&mycenter=1&mobile=2"><img src="/images/mall/mobile/icon-profile.png" width="30" /><span>个人中心</span></a>
            </li>
        </ul>
    </div>