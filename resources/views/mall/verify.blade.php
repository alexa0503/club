@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container" style="padding-top: 60px;padding-bottom: 40px;position: relative;">
        <!--nav-->
        <div class="hidden-xs" style=" position: absolute; left: 0; top: 0; padding-left: 19px; height: 29px;"><a href="./" class="nvhm" title="首页" style=" float: left; height: 29px; width: 16px; background: url(http://club.dffengguang.com.cn/bbs/static/image/common/search.png) no-repeat 0 0; line-height: 200px; overflow: hidden; text-decoration: none; color: #5f2927;">超级风迷东风风光车友会</a><em style=" display: block; width: 20px; background: url(http://club.dffengguang.com.cn/bbs/static/image/common/pt_item.png) no-repeat 3px 10px; line-height: 29px; overflow: hidden; float: left; height: 100%;"></em><a href="http://club.dffengguang.com.cn/bbs/home.php?mod=spacecp" style=" line-height: 29px; color: #5f2927; float: left; height: 29px; font-size: 12px;">设置</a><em style=" display: block; width: 20px; background: url(http://club.dffengguang.com.cn/bbs/static/image/common/pt_item.png) no-repeat 3px 10px; line-height: 29px; overflow: hidden; float: left; height: 100%; "></em><div style=" font-size: 12px; color: #444; float: left; height: 100%; line-height: 29px; /* display: block; */">车主认证</div></div>

            <div class="row">
                <div class="col-sm-2 col-md-2 col-xs-2 hidden-xs" style="padding-left: 0px;">
                <h2 style="
                            padding: 10px;
                            border-bottom: 1px dashed #CDCDCD;
                            font-size: 16px;
                            font-weight: bold;
                            color: #444;
                            background: #e8f0f7;
                            margin: 0;
                            width: 137px;
                        ">设置</h2>
                    <div class="list-group"  style="width: 137px;">
                        <a href="/bbs/home.php?mod=spacecp&ac=avatar" class="list-group-item">修改头像</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=profile" class="list-group-item">个人资料</a>
                        <a href="javascript:;" class="list-group-item active ">
                            车主认证
                        </a>
                        <!--<a href="{{url('/reference')}}" class="list-group-item">推荐购车</a>-->
                        <a href="/bbs/home.php?mod=spacecp&ac=credit" class="list-group-item">评级积分</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=credit4" class="list-group-item">风迷币</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=usergroup" class="list-group-item">用户组</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=privacy" class="list-group-item">隐私筛选</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=profile&op=password" class="list-group-item">密码安全</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=promotion" class="list-group-item">访问推广</a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-xs-10">
                    {{ Form::open(array('url' => url('/verify'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'verify-form')) }}
                    <div class="form-group" id="form-group-frame_number">
                        <label for="frame_number" class="col-sm-2 col-md-2 col-xs-10 control-label">车架号:</label>
                        <div class="col-sm-10 col-md-10 col-xs-12">
                            <input class="form-control" type="text" value="" id="frame_number" name="frame_number" placeholder="输入后八位车架号">
                            <label class="help-block" for="frame_number" id="help-frame_number"></label>
                        </div>
                    </div>
                    <div class="form-group" id="form-group-id_card">
                        <label for="id_card" class="col-sm-2 col-md-2 col-xs-10 control-label">姓名:</label>
                        <div class="col-sm-10 col-md-10 col-xs-12">
                            <input class="form-control" type="text" value="" id="id_card" name="id_card" placeholder="输入姓名">
                            <label class="help-block" for="id_card" id="help-id_card"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-10 col-xs-10 col-md-offset-2">
                            <button type="submit" class="btn btn-custom">认证</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                    <div class="rows hidden-xs" style="margin-top: 40px;">
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
                                            <td>姓名</td>
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
                                        <tr>
                                            <td>认证状态</td>
                                            <td>{{$verify->status == -1 ? '已退车失效' : '正常'}}</td>
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
            $('#verify-form').ajaxForm({
                dataType: 'json',
                success: function(json) {
                    $('.help-block').html('');
                    $('.form-group').removeClass('has-error');
                    if (json.ret == 0){
                        $('.modal').modal('hide');
                        $('#modal-tip').find('.modal-body').html(json.msg);
                        $('#modal-tip').find('.modal-title').html('恭喜');
                        $('#modal-tip').modal('show');
                        $('#modal-tip').modal('show').on('hidden.bs.modal', function () {
                            window.location.reload();
                        });
                        //window.location.reload();
                        //$('#modal-tip').modal('show');
                    }
                    else{
                        $('.modal').modal('hide');
                        $('#modal-tip').find('.modal-body').html(json.msg);
                        $('#modal-tip').find('.modal-title').html('抱歉');
                        $('#modal-tip').modal('show');
                    }
                },
                error: function(xhr){
                    $('.help-block').html('');
                    $('.form-group').removeClass('has-error');
                    var json = jQuery.parseJSON(xhr.responseText);
                    if (xhr.status == 200){
                        $('#post-form').modal('hide');
                    }
                    $.each(json, function(index,value){
                        $('#form-group-'+index).addClass('has-error');
                        $('#help-'+index).html(value);
                    });
                }
            });
        })
    </script>
@endsection
