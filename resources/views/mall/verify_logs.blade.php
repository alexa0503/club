@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container" style="padding-top: 40px;padding-bottom: 40px;">
            <div class="row">
                <div class="col-md-2">
                    <div class="list-group">

                        <a href="/bbs/home.php?mod=spacecp&ac=avatar" class="list-group-item">修改头像</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=profile" class="list-group-item">个人资料</a>
                        <a href="{{url('/verify')}}" class="list-group-item ">
                            车主认证
                        </a>
                        <a href="{{url('/verify/logs')}}" class="list-group-item  list-group-item-danger">认证历史</a>
                        <a href="{{url('/reference')}}" class="list-group-item">推荐购车</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=credit" class="list-group-item">评级积分</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=credit4" class="list-group-item">风迷币</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=usergroup" class="list-group-item">用户组</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=privacy" class="list-group-item">隐私筛选</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=profile&op=password" class="list-group-item">密码安全</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=promotion" class="list-group-item">访问推广</a>
                    </div>
                </div>
                <div class="col-md-10">
                    <ul id="myTab" class="nav nav-tabs">
                    @foreach($verifies as $k=>$verify)
                        @if($k<5)
                        <li @if($k==0)class="active"@endif>
                            <a href="#veirfy{{$k}}" data-toggle="tab">
                                @if($k == 0)
                                首次认证
                                @else
                                第{{$k+1}}次认证
                                @endif
                            </a>
                        </li>
                        @endif
                    @endforeach
                    @if(count($verifies)>5)
                    <li class="dropdown">
                        <a href="#" id="verifyTabDrop" class="dropdown-toggle"
                           data-toggle="dropdown">更多
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="verifyTabDrop">
                            @foreach($verifies as $k=>$verify)
                            @if($k>=5)
                            <li><a href="#veirfy{{$k}}" tabindex="-1" data-toggle="tab">第{{$k+1}}次认证</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    </ul>
                    <div id="tab-verify" class="tab-content">
                        @foreach($verifies as $k=>$verify)
                        <div class="tab-pane fade in {{$k==0?'active':''}}" id="veirfy{{$k}}">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td style="border-top: none;">车架号</td>
                                    <td style="border-top: none;">{{$verify->frame_number}}</td>
                                </tr>
                                <tr>
                                    <td>身份证</td>
                                    <td>{{$verify->id_card}}</td>
                                </tr>
                                <tr>
                                    <td>车型</td>
                                    <td>{{$verify->model_code}}</td>
                                </tr>
                                <tr>
                                    <td>认证时间</td>
                                    <td>{{$verify->created_at}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
        })
    </script>
@endsection