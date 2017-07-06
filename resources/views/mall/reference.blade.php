@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container" style="padding-top: 40px;padding-bottom: 40px;">
            <div class="row">
                <div class="col-md- col-xs-2">
                    <div class="list-group">
                        <a href="/bbs/home.php?mod=spacecp&ac=avatar" class="list-group-item">修改头像</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=profile" class="list-group-item">个人资料</a>
                        <a href="{{url('/verify')}}" class="list-group-item">
                            车主认证
                        </a>
                        <a href="{{url('/verify/logs')}}" class="list-group-item">认证历史</a>
                        <a href="{{url('/reference')}}" class="list-group-item list-group-item-danger">推荐购车</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=credit" class="list-group-item">评级积分</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=credit4" class="list-group-item">风迷币</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=usergroup" class="list-group-item">用户组</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=privacy" class="list-group-item">隐私筛选</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=profile&op=password" class="list-group-item">密码安全</a>
                        <a href="/bbs/home.php?mod=spacecp&ac=promotion" class="list-group-item">访问推广</a>
                    </div>
                </div>
                <div class="col-md-8 col-xs-8">
                    {{ Form::open(array('url' => url('/reference'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'verify-form')) }}
                    <div class="form-group" id="form-group-frame_number">
                        <label for="frame_number" class="col-md-2 col-xs-2 control-label">车架号:</label>
                        <div class="col-md-10 col-xs-10">
                            <input class="form-control" type="text" value="" id="frame_number" name="frame_number" placeholder="输入车架号">
                            <label class="help-block" for="frame_number" id="help-frame_number"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group" id="form-group-username">
                        <label for="username" class="col-md-2 col-xs-2 control-label">推荐用户名:</label>
                        <div class="col-md-10 col-xs-10">
                            <input class="form-control" type="text" value="" id="username" name="username" placeholder="输入推荐用户名">
                            <label class="help-block" for="username" id="help-username"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <div class="col-md-10 col-xs-10 col-md-offset-2">
                            <button type="submit" class="btn btn-custom">认证</button>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    {{ Form::close() }}
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
                            window.location.href = '{{url("/")}}';
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