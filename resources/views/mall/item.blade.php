@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container">
            <div class="row" id="item-top">
                <div class="pull-right" style="width:640px;" id="item-detail">
                    <div class="title">{{$item->name}}</div>
                    <div class="subtitle">{{$item->subtitle}}</div>
                        {{ Form::open(array('url' => url('/mall/cart'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'post-form')) }}
                        <div class="form-group">
                            <label for="price" class="col-md-2 col-xs-2 control-label">价格:</label>
                            <div class="col-md-10 col-xs-10"><label class="" for="" style="color:red;">{{$item->point}}风迷币</label></div><!-- /.col -->
                        </div><!-- /form-group -->
                    @if(count($item->inventories) <= 1 && $item->inventories[0]['color'] == 'default')
                        <input type="hidden" value="{{$item->inventories[0]['color']}}" name="color" />
                    @else
                        <div class="form-group" id="form-group-color">
                            <label for="color" class="col-md-2 col-xs-2 control-label">选择:</label>
                            <div class="col-md-10 col-xs-10">
                                <div style="width:100%;height:40px;">
                                    <div class="funkyradio">
                                        @foreach($item->inventories as $k=>$inventory)
                                            <div class="funkyradio-default">
                                                <input type="radio" value="{{$inventory['color']}}" name="color" id="radio{{$k}}" />
                                                <label for="radio{{$k}}">{{$inventory['color']}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <label class="help-block" for="" id="help-color"></label>
                            </div><!-- /.col -->
                        </div><!-- /form-group -->
                    @endif

                        <div class="form-group" id="form-group-quantity">
                            <label for="quantity" class="col-md-2 col-xs-2 control-label">数量:</label>
                            <div class="col-md-10 col-xs-10">
                                <div>
                                    <div class="input-group" style="width: 100px;">
                                        <span class="input-group-addon" id="item-increase">+</span>
                                        <input type="text" value="1" class="form-control" placeholder="" aria-describedby="basic-addon1" name="quantity" style="width: 60px;text-align: center">
                                        <span class="input-group-addon" id="item-decrease">-</span>
                                    </div>
                                </div>

                                <label class="help-block" for="" id="help-quantity"></label></div><!-- /.col -->
                        </div><!-- /form-group -->
                    <input type="hidden" value="{{$item->id}}" name="item_id" />
                    <button type="button" id="buy-now" class="btn-submit btn btn-lg btn-custom">立即兑换</button>
                    <button type="button" id="add-to-cart" class="btn-submit btn btn-lg btn-custom">加入购物车</button>
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

@endsection
@section('scripts')

    <script>
        $().ready(function () {
            $('#item-increase').on('click', function () {
               var v = parseInt($('input[name=quantity]').val());
                $('input[name=quantity]').val(v+1);
            });
            $('#item-decrease').on('click', function () {
                var v = parseInt($('input[name=quantity]').val());
                if ( v < 2){
                    alert('不能再减少啦')
                }
                else{
                    $('input[name=quantity]').val(v-1);
                }
            });
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
            $('.btn-submit').on('click', function () {
                var id = $(this).attr('id');
                $('.help-block').html('');
                $('.form-group').removeClass('has-error');
                $('#post-form').ajaxSubmit({
                    dataType: 'json',
                    success: function(json) {
                        if (json.ret == 1100){
                            $('#modal-login').modal('show');
                        }
                        else if(json.ret == 0){
                            if (id == 'add-to-cart'){
                                $('#modal-tip').find('.modal-body').html(json.msg);
                                $('#modal-tip').find('.modal-title').html('成功');
                                $('#modal-tip').modal('show');
                            }
                            else{
                                window.location.href = '{{url("/mall/cart")}}';
                            }
                            ajaxCart();
                        }
                        else{
                            $('#modal-tip').find('.modal-body').html(json.msg);
                            $('#modal-tip').find('.modal-title').html('抱歉');
                            $('#modal-tip').modal('show');
                        }
                    },
                    error: function(xhr){
                        var json = jQuery.parseJSON(xhr.responseText);
                        if (xhr.status == 200){
                        }

                        $.each(json, function(index,value){
                            $('#form-group-'+index).addClass('has-error');
                            $('#help-'+index).html(value.join("<br/>"));
                        });
                    }
                });
            })
        })
    </script>
@endsection