@extends('layouts.admin')
@section('content')
    <div class="smart-widget widget-purple">
		<div class="smart-widget-inner">
			<div class="smart-widget-body">
                {{ Form::open(array('route' => ['item.store'], 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'post-form')) }}
                <div class="form-group">
                    <label for="name" class="col-lg-2 control-label">产品名</label>
                    <div class="col-lg-10">
                        <input value="" name="name" type="text" class="form-control" id="name" placeholder="请输入产品名">
                        <label class="help-block" for="" id="help-name"></label>
                    </div><!-- /.col -->
                </div><!-- /form-group -->

                <div class="form-group">
                    <label for="subtitle" class="col-lg-2 control-label">副标题</label>
                    <div class="col-lg-10">
                        <input value="" name="subtitle" type="text" class="form-control" id="subtitle" placeholder="请输入副标题">
                        <label class="help-block" for="" id="help-subtitle"></label>
                    </div><!-- /.col -->
                </div><!-- /form-group -->

                <div class="form-group">
                    <label for="feature1" class="col-lg-2 control-label">爆款推荐[大于0整数为推荐]</label>
                    <div class="col-lg-10">
                        <input value="" name="feature1" type="text" class="form-control" id="name" placeholder="请输入产品名">
                        <label class="help-block" for="" id="help-feature1"></label>
                    </div><!-- /.col -->
                </div><!-- /form-group -->

                <div class="form-group">
                    <label for="feature2" class="col-lg-2 control-label">车载必备[大于0整数为推荐]</label>
                    <div class="col-lg-10">
                        <input value="" name="feature2" type="text" class="form-control" id="name" placeholder="请输入产品名">
                        <label class="help-block" for="" id="help-feature2"></label>
                    </div><!-- /.col -->
                </div><!-- /form-group -->

                    <div class="form-group">
						<label for="name" class="col-lg-2 control-label">产品图片</label>
						<div class="col-lg-10">
                            <div class="row">
                                <div class="col-md-3" id="thumbs-add">
                                    <a href="javascript:;" class="thumbnail" onclick="javascript:window.open('{{url("/filemanager?type=Images")}}','upload','fullscreen=no,width=1000,height=600',true);" style="text-align:center"><img src="{{asset('images/material-icon-plus.png')}}" /></a>
                                </div>
                            </div>

                            <label class="help-block" for="" id="help-images"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="content" class="col-lg-2 control-label">产品描述</label>
						<div class="col-lg-10">
                            <textarea name="content" class="article-ckeditor form-control" id="content" rows="20"></textarea>
                            <label class="help-block" for="" id="help-content"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="price" class="col-lg-2 control-label">市场价</label>
						<div class="col-lg-10">
							<input value="" name="price" type="text" class="form-control" id="price" placeholder="">
                            <label class="help-block" for="" id="help-price"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
                        <label for="point" class="col-lg-2 control-label">兑换风迷币</label>
                        <div class="col-lg-10">
                            <input value="" name="point" type="text" class="form-control" id="point" placeholder="">
                            <label class="help-block" for="" id="help-point"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->



                    <div class="form-group">
                        <label for="colors" class="col-lg-2 control-label">产品颜色</label>
                        <div class="col-lg-10">
                            <select name="colors[]" multiple="multiple" class="select2 form-control" id="colors"></select>
                            <label class="help-block" for="" id="help-colors"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->

                    <div class="form-group">
                        <label for="quantities" class="col-lg-2 control-label">对应颜色库存量</label>
                        <div class="col-lg-10">
                            <select name="quantities[]" multiple="multiple" class="select2 form-control" id="quantities"></select>
                            <label class="help-block" for="" id="help-quantities"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->

					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button type="submit" class="btn btn-success btn-sm">提交</button>
						</div><!-- /.col -->
					</div><!-- /form-group -->
				{{ Form::close() }}
			</div>
		</div><!-- ./smart-widget-inner -->
	</div>
@endsection
@section('scripts')
<!--form-->
<script src="{{asset('js/jquery.form.js')}}"></script>
<script src="/vendor/unisharp/laravel-ckeditor/ckeditor.js"></script>
<script src="{{asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
<script>
function thumbRemove(obj) {
    if(confirm('确认删除?')){
        obj.parent('.col-md-3').remove();
    }
}
function SetUrl(url1,url2){
    var url = '{{url("/")}}'+url2.replace('//','/');
    var html = '';
    html += '<div class="col-md-3"><a href="javascript:;" title="点击删除" onclick="thumbRemove($(this))" class="thumbnail"><img src="'+url+'" /></a><input type="hidden" name="images[]" value="'+url+'"></div>';
    $('#thumbs-add').before(html);
}
 $().ready(function(){
     $('.article-ckeditor').ckeditor({
         filebrowserBrowseUrl: '{!! url("/filemanager?type=Images") !!}'
     });
     $('.select2').select2({
 		tags: true,
 		language: "zh-CN",
 		placeholder: "请输入",
 	});



    $('#post-form').ajaxForm({
        dataType: 'json',
        success: function(json) {
            $('#post-form').modal('hide');
            location.href= json.url;
        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
            if (xhr.status == 200){
                $('#post-form').modal('hide');
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
