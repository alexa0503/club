@if(Agent::isMobile())
    <div class="car-bar">
        <ul class="nav nav-pills">
            <li class="{{ $active == 'mall' ? 'active':'' }}">
                <a href="/mall"><i class="icon-bar icon-cart"></i><span>礼品兑换</span></a>
            </li>
            <li class="{{ $active == 'club' ? 'active':'' }}">
                <a href="/bbs/forum.php"><i class="icon-bar icon-club"></i><span>风迷社区</span></a>
            </li>
            <li class="{{ $active == 'profile' ? 'active':'' }}">
                <a href="/profile"><i class="icon-bar icon-profile"></i><span>会员信息</span></a>
            </li>
        </ul>
    </div>
@endif