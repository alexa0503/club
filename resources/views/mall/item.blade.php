@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container">
            <div class="row" id="item-top">
                <div class="pull-right" style="width:640px;" id="item-detail">
                    <div class="title">{{$item->name}}</div>
                    <div class="subtitle">{{$item->subtitle}}</div>
                        {{ Form::open(array('url' => url('/mall/buy'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'post-form')) }}
                        <div class="form-group">
                            <label for="price" class="col-md-2 col-xs-2 control-label">市场价:</label>
                            <div class="col-md-10 col-xs-10"><label class="" for="" style="color:red;">{{$item->point}}风迷币</label></div><!-- /.col -->
                        </div><!-- /form-group -->
                        <div class="form-group" id="form-group-inventory">
                            <label for="inventory" class="col-md-2 col-xs-2 control-label">选择:</label>
                            <div class="col-md-10 col-xs-10">
                                <div style="width:100%;height:40px;">
                                    <div class="funkyradio">
                                        @foreach($item->inventories as $k=>$inventory)
                                            <div class="funkyradio-default">
                                                <input type="radio" value="{{$k}}" name="inventory" id="radio{{$k}}" />
                                                <label for="radio{{$k}}">{{$inventory['color']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <label class="help-block" for="" id="help-inventory"></label>
                            </div><!-- /.col -->
                        </div><!-- /form-group -->
                        <div class="form-group" id="form-group-quantity">
                            <label for="quantity" class="col-md-2 col-xs-2 control-label">数量:</label>
                            <div class="col-md-10 col-xs-10">
                                <div>
                                    <div class="input-group" style="width: 100px;">
                                        <span class="input-group-addon" id="basic-addon1">+</span>
                                        <input type="text" value="1" class="form-control" placeholder="" aria-describedby="basic-addon1" name="quantity">
                                        <span class="input-group-addon" id="basic-addon1">-</span>
                                    </div>
                                </div>

                                <label class="help-block" for="" id="help-quantity"></label></div><!-- /.col -->
                        </div><!-- /form-group -->
                    <input type="hidden" value="{{$item->id}}" name="item_id" />
                        <button type="submit" class="btn btn-lg btn-custom">立即兑换</button>
                    {{ Form::close() }}
                </div>
                <div id="images">
                    <div class="slider slider-for">
                        @foreach($item->images as $image)
                            <div><img src="{{$image}}" width="400" height="400"/></div>
                        @endforeach
                    </div>
                    <div class="slider slider-nav">
                        @foreach($item->images as $image)
                            <div><img src="{{$image}}" width="50" height="50"/></div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row" id="item-content">
                {!! $item->content !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-address" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="">收货人信息</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('url' => url('/mall/address'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'address-form')) }}
                    <div class="form-group" id="form-group-name">
                        <label for="name" class="col-md-2 col-xs-2 control-label">* 收货人:</label>
                        <div class="col-md-10 col-xs-10">
                            <input class="form-control" type="text" value="" id="username" name="name">
                            <label class="help-block" for="name" id="help-name"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->

                    <div class="form-group" id="form-group-detail">
                        <label for="detail" class="col-md-2 col-xs-2 control-label">* 详细地址:</label>
                        <div class="col-md-10 col-xs-10">
                            <input class="form-control" type="text" value="" id="detail" name="detail">
                            <label class="help-block" for="detail" id="help-detail"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->

                    <div class="form-group" id="form-group-mobile">
                        <label for="username" class="col-md-2 col-xs-2 control-label">* 手机号码:</label>
                        <div class="col-md-10 col-xs-10">
                            <input class="form-control" type="text" value="" id="mobile" name="mobile">
                            <label class="help-block" for="mobile" id="help-mobile"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->

                    <div class="form-group" id="form-group-telephone">
                        <label for="telephone" class="col-md-2 col-xs-2 control-label">固定电话:</label>
                        <div class="col-md-10 col-xs-10">
                            <input class="form-control" type="text" value="" id="telephone" name="telephone">
                            <label class="help-block" for="telephone" id="help-telephone"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <input type="hidden" value="{{$item->id}}" name="item_id" />
                    <input type="hidden" value="" name="inventory" id="order-inventory" />
                    <input type="hidden" value="" name="quantity" id="order-quantity" />
                    <div class="form-group">
                        <div class="col-md-10 col-xs-10 col-md-offset-2 col-xs-offset-2">
                            <button type="submit" class="btn btn-custom">确认并购买</button>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    {{ Form::close() }}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection
@section('scripts')

    <script>
        $().ready(function () {

            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                asNavFor: '.slider-nav'
            });
            $('.slider-nav').slick({
                slidesToShow: false,
                slidesToScroll: 0,
                asNavFor: '.slider-for',
                dots: false,
                centerMode: false,
                focusOnSelect: true
            });
            $('#post-form').ajaxForm({
                dataType: 'json',
                success: function(json) {
                    var v1 = $('input[name=inventory]:checked','#post-form').val();
                    var v2 = $('input[name=quantity]','#post-form').val();
                    $('#order-inventory').val(v1);
                    $('#order-quantity').val(v2);
                    if (json.ret == 1100){
                        $('#modal-login').modal('show');
                    }
                    else if(json.ret == 1001){
                        $('#modal-tip').find('.modal-body').html(json.msg);
                        $('#modal-tip').modal('show');
                    }
                    else{
                        $('#modal-address').modal('show');
                    }

                },
                error: function(xhr){
                    var json = jQuery.parseJSON(xhr.responseText);
                    if (xhr.status == 200){
                    }
                    $('.help-block').html('');
                    $.each(json, function(index,value){
                        $('#form-group-'+index).addClass('has-error');
                        $('#help-'+index).html(value);
                    });
                }
            });
            $('#address-form').ajaxForm({
                dataType: 'json',
                success: function(json) {
                    $('.help-block').html('');
                    $('.form-group').removeClass('has-error');
                    if (json.ret == 0){
                        $('.modal').modal('hide');
                        $('#modal-tip').find('.modal-body').html(json.msg);
                        $('#modal-tip').find('.modal-title').html('购买成功!');
                        $('#modal-tip').modal('show');
                    }
                    else{
                        $('.modal').modal('hide');
                        $('#modal-tip').find('.modal-body').html(json.msg);
                        $('#modal-tip').find('.modal-title').html('购买失败!');
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
            $.getJSON('{{url("/address")}}', function (json) {
                if (json.return == 0){
                    $.each(function (index,value) {
                        $('#'+index).val(value);
                    })

                }
            })
        })
    </script>
@endsection