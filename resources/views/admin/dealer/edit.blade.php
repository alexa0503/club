@extends('layouts.admin')
@section('content')
    <div class="smart-widget widget-purple">
		<div class="smart-widget-inner">
			<div class="smart-widget-body">
                {{ Form::open(array('route' => ['dealer.update',$dealer->id], 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'post-form')) }}
                <div class="form-group">
                    <label for="name" class="col-lg-2 col-md-2 control-label">名称</label>
                    <div class="col-lg-10 col-md-10">
                        <input value="{{ $dealer->name }}" name="name" type="text" class="form-control" id="name" placeholder="">
                        <label class="help-block" for="" id="help-name"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="qq" class="col-lg-2 col-md-2 control-label">QQ</label>
                    <div class="col-lg-10 col-md-10">
                        <input value="{{ $dealer->qq }}" name="qq" type="text" class="form-control" id="qq" placeholder="">
                        <label class="help-block" for="" id="help-qq"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel" class="col-lg-2 col-md-2 control-label">电话</label>
                    <div class="col-lg-10 col-md-10">
                        <input value="{{ $dealer->tel }}" name="tel" type="text" class="form-control" id="tel" placeholder="">
                        <label class="help-block" for="" id="help-tel"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="intro" class="col-lg-2 col-md-2 control-label">简介</label>
                    <div class="col-lg-10 col-md-10">
                        <textarea name="intro" type="text" class="form-control" id="intro">{{ $dealer->intro }}</textarea>
                        <label class="help-block" for="" id="help-intro"></label>
                    </div>
                </div>
				<div class="form-group">
					<div class="col-lg-offset-2 col-md-offset-2 col-lg-10 col-md-10">
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
 		tags: false,
 		language: "zh-CN",
 		placeholder: "请选择",
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
