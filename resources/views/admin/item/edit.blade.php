@extends('layouts.admin')
@section('content')
<div class="smart-widget widget-purple">
    <div class="smart-widget-inner">
        <div class="smart-widget-body">
            {{ Form::open(array('route' => ['item.update',$item->id], 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'post-form')) }}
            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">产品名</label>
                <div class="col-lg-10">
                    <input value="{{$item->name}}" name="name" type="text" class="form-control" id="name" placeholder="请输入产品名">
                    <label class="help-block" for="" id="help-name"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="subtitle" class="col-lg-2 control-label">副标题</label>
                <div class="col-lg-10">
                    <input value="{{$item->subtitle}}" name="subtitle" type="text" class="form-control" id="subtitle" placeholder="请输入副标题">
                    <label class="help-block" for="" id="help-subtitle"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="product_code" class="col-lg-2 control-label">产品编号</label>
                <div class="col-lg-10">
                    <input value="{{$item->product_code}}" name="product_code" type="text" class="form-control" id="product_code" placeholder="请输入产品编号">
                    <label class="help-block" for="" id="help-product_code"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="category_id" class="col-lg-2 control-label">商品分类</label>
                <div class="col-lg-10">
                    <select name="category_id" class="form-control" id="category_id">
                        @foreach( $categories as $category )
                        <option value="{{$category->id}}" @if($category->id == $item->category_id){{'selected="selected'}}"@endif>{{$category->name}}</option>
                        @endforeach
                    </select>
                    <label class="help-block" for="" id="help-category_id"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="dealer_id" class="col-lg-2 control-label">经销商</label>
                <div class="col-lg-10">
                    <select name="dealer_id" class="form-control" id="dealer_id">
                        @foreach( $dealers as $dealer )
                        <option value="{{$dealer->id}}" {{ $dealer->id == $item->dealer_id ? 'selected="selected"' : '' }} >{{$dealer->name}}</option>
                        @endforeach
                    </select>
                    <label class="help-block" for="" id="help-dealer_id"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="type" class="col-lg-2 control-label">商品性质</label>
                <div class="col-lg-10">
                    <select name="type" class="form-control" id="type"><option value="0">普通商品</option><option value="1" {{$item->type==1 ? 'selected="selected"':''}}>优惠券</option></select>
                    <label class="help-block" for="" id="help-type"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="valid_date" class="col-lg-2 control-label">有效期[仅优惠券有效]</label>
                <div class="col-lg-10">
                    <input value="{{$item->valid_date}}" name="valid_date" type="text" class="form-control" id="valid_date" placeholder="">
                    <label class="help-block" for="" id="help-valid_date"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="feature1" class="col-lg-2 control-label">爆款推荐[大于0整数为推荐]</label>
                <div class="col-lg-10">
                    <input value="{{$item->feature1}}" name="feature1" type="text" class="form-control" id="feature1" placeholder="">
                    <label class="help-block" for="" id="help-feature1"></label>
                </div>
            </div>
            <div class="form-group">
                <label for="feature2" class="col-lg-2 control-label">商品排序[从小到大显示]</label>
                <div class="col-lg-10">
                    <input value="{{$item->feature2}}" name="feature2" type="text" class="form-control" id="feature2" placeholder="">
                    <label class="help-block" for="" id="help-feature2"></label>
                </div>
            </div>


            <div class="form-group">
                <label for="price" class="col-lg-2 control-label">市场价</label>
                <div class="col-lg-10">
                    <input value="{{$item->price}}" name="price" type="text" class="form-control" id="price" placeholder="">
                    <label class="help-block" for="" id="help-price"></label>
                </div>
            </div>

             <div class="form-group">
                <label for="coupon_value" class="col-lg-2 control-label">面额[优惠券专用]</label>
                <div class="col-lg-10">
                    <input value="{{$item->coupon_value}}" name="coupon_value" type="text" class="form-control" id="coupon_value" placeholder="">
                    <label class="help-block" for="" id="help-coupon_value"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="point" class="col-lg-2 control-label">兑换风迷币</label>
                <div class="col-lg-10">
                    <input value="{{$item->point}}" name="point" type="text" class="form-control" id="point" placeholder="">
                    <label class="help-block" for="" id="help-point"></label>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">产品图片</label>
                <div class="col-lg-10">
                    <div class="row">
                        @foreach($item->images as $image)
                        <div class="col-md-3"><a href="javascript:;" title="点击删除" onclick="thumbRemove($(this))" class="thumbnail"><img src="{{$image}}" /></a><input type="hidden" name="images[]" value="{{$image}}"></div>
                        @endforeach
                        <div class="col-md-3" id="thumbs-add">
                            <a href="javascript:;" class="thumbnail" onclick="javascript:window.open('{{url("/filemanager?type=Images")}}','upload','fullscreen=no,width=1000,height=600',true);" style="text-align:center"><img src="{{asset('images/material-icon-plus.png')}}" /></a>
                        </div>
                    </div>

                    <label class="help-block" for="" id="help-images"></label>
                </div>
            </div>

            <div class="form-group">
                <label for="content" class="col-lg-2 control-label">产品描述</label>
                <div class="col-lg-10">
                    <textarea name="content" class="article-ckeditor form-control" id="content" rows="20">{!! $item->content !!}</textarea>
                    <label class="help-block" for="" id="help-content"></label>
                </div>
            </div>





            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
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
