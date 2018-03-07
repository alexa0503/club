@extends('layouts.admin')
@section('content')
    <div class="smart-widget widget-purple">
		<div class="smart-widget-inner">
			<div class="smart-widget-body">
                {{ Form::open(array('route' => ['credit.store'], 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'post-form')) }}
                <div class="form-group">
                    <label for="username" class="col-lg-4 col-md-4 control-label">用户名<br/>[多个用户以半角逗号,分开]</label>
                    <div class="col-lg-8 col-md-8">
                        <input value="" name="username" type="text" class="form-control" id="username" placeholder="请输入用户名">
                        <label class="help-block" for="" id="help-username"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="extcredits1" class="col-lg-4 col-md-4 control-label">积分<br/>[负数为扣除]</label>
                    <div class="col-lg-8 col-md-8">
                        <input value="" name="extcredits1" type="text" class="form-control" id="extcredits1" placeholder="请输入积分">
                        <label class="help-block" for="" id="help-extcredits1"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="extcredits4" class="col-lg-4 col-md-4 control-label">风迷币<br/>[负数为扣除]</label>
                    <div class="col-lg-8 col-md-8">
                        <input value="" name="extcredits4" type="text" class="form-control" id="extcredits4" placeholder="请输入风迷币">
                        <label class="help-block" for="" id="help-extcredits4"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="title" class="col-lg-4 col-md-4 control-label">变更理由标题</label>
                    <div class="col-lg-8 col-md-8">
                        <input value="" name="title" type="text" class="form-control" id="title" placeholder="请输入变更理由标题">
                        <label class="help-block" for="" id="help-title"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="text" class="col-lg-4 col-md-4 control-label">变更理由描述</label>
                    <div class="col-lg-8 col-md-8">
                        <textarea class="form-control" id="text" name="text" placeholder="请输入变更理由描述"></textarea>
                        <label class="help-block" for="" id="help-text"></label>
                    </div>
                </div>
				<div class="form-group">
					<div class="col-lg-offset-4 col-md-offset-4 col-lg-8 col-md-8">
						<button type="submit" class="btn btn-success btn-sm">提交</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
		</div><!-- ./smart-widget-inner -->
	</div>
@endsection
@section('scripts')
<!--form-->
<script src="{{asset('js/jquery.form.js')}}"></script>
<script>
 $().ready(function(){
     $('.select2').select2({
 		tags: true,
 		language: "zh-CN",
 		placeholder: "请输入",
 	});


    $('#post-form').ajaxForm({
        dataType: 'json',
        success: function(json) {
            //$('#post-form').modal('hide');
            $('.form-group').removeClass('has-error');
            alert('操作成功！');
            location.href= json.url;
        },
        error: function(xhr){
            $('.form-group').removeClass('has-error');
            var json = jQuery.parseJSON(xhr.responseText);
            if (xhr.status == 200){
                //$('#post-form').modal('hide');
                alert('操作成功！');
                location.href= json.url;
            }
            $('.help-block').html('');
            $.each(json, function(index,value){
                $('#'+index).parents('.form-group').addClass('has-error');
                $('#help-'+index).html(value);
                //$('#'+index).next('.help-block').html(value);
            });
        }
    });
 })
</script>
@endsection
