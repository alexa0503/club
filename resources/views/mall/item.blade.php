@extends('layouts.mall') @section('content')
<div id="main">
    <div class="container">
        <div class="row" id="item-top">
            @if(!Agent::isMobile())
            <div class="pull-right hidden-xs" style="width:640px;" id="item-detail">
                <div class="title">{{$item->name}}</div>
                <div class="subtitle">{{$item->subtitle}}</div>
                {{ Form::open(array('url' => url('/mall/cart'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'post-form')) }}
                <div class="form-group">
                    <label for="price" class="col-md-2 col-xs-2 control-label">价格:</label>
                    <div class="col-md-10 col-xs-10">
                        <label class="" for="" style="color:red;">{{$item->point}}风迷币</label>
                    </div>
                </div>
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

                        <label class="help-block" for="" id="help-quantity"></label>
                    </div>
                </div>
                <input type="hidden" value="{{$item->id}}" name="item_id" />
                <button type="button" id="buy-now" class="btn-submit btn btn-lg btn-custom">立即兑换</button>
                <button type="button" id="add-to-cart" class="btn-submit btn btn-lg btn-custom">加入购物车</button>
                <button type="button" data-url="{{ url('/mall/favourite/'.$item->id) }}" class="btn-star btn btn-lg {{ $has_favoured ? '' : 'btn-star-gray' }}">
                    <span class="glyphicon glyphicon-star " aria-hidden="true"></span>
                </button>
                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin={{$item->dealer->qq}}&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:{{$item->dealer->qq}}:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
                {{ Form::close() }}
            </div>
            @endif
            <div id="images">
                <div class="slider slider-for">
                    @foreach($item->images as $image)
                    <div>
                        <img src="{{$image}}" width="400" height="400" />
                    </div>
                    @endforeach
                </div>
                <div class="slider slider-nav">
                    @foreach($item->images as $image)
                    <div>
                        <img src="{{$image}}" width="50" height="50" />
                    </div>
                    @endforeach
                </div>
                <div class="item-detail-favourite">
                    <button type="button" data-url="{{ url('/mall/favourite/'.$item->id) }}" class="btn-star btn btn-lg {{ $has_favoured ? '' : 'btn-star-gray ' }}">
                        <span class="glyphicon glyphicon-star " aria-hidden="true"></span>
                        <br/>收藏
                    </button>
                    <a href="tel:{{$item->dealer->tel}}"><img src="/images/mall/mobile/service.png" height="26" style="margin-bottom:4px;" /><br/>客服</a>
                </div>
            </div>
            @if(Agent::isMobile())
            <div class="visiable-xs-block item-detail">
                <div class="title">{{$item->name}}</div>
                <div class="subtitle">{{$item->subtitle}}</div>
                {{ Form::open(array('url' => url('/mall/cart'), 'class'=>'form-horizontal', 'method'=>'POST', 'id'=>'post-form')) }}
                <div class="form-group">
                    价格：<font color="red">{{$item->point}}风迷币</font>
                </div>
                <div class="form-group" id="form-group-quantity">
                    数量：
                     <div class="item-detail-group">
                        <div class="input-group" style="width: 100px;">
                            <span class="input-group-addon" id="item-increase">+</span>
                            <input type="text" value="1" class="form-control" placeholder="" aria-describedby="basic-addon1" name="quantity" style="width: 60px;text-align: center">
                            <span class="input-group-addon" id="item-decrease">-</span>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="{{$item->id}}" name="item_id" />
                <div class="item-detail-btns">
                    <button type="button" id="buy-now" class="btn-submit btn btn-lg btn-custom">立即兑换</button><button type="button" id="add-to-cart" class="btn-submit btn btn-lg btn-custom">加入购物车</button>
                </div>
                
                {{ Form::close() }}
            </div>
            @endif
        </div>
        <div class="row" id="item-content">
            {!! $item->content !!}
        </div>
    </div>
</div>

@include('mall.mobile.car_bar',['active'=>'mall']) @endsection @section('scripts')

<script>
    $().ready(function () {
        $('#item-increase').on('click', function () {
            var v = parseInt($('input[name=quantity]').val());
            $('input[name=quantity]').val(v + 1);
        });
        $('#item-decrease').on('click', function () {
            var v = parseInt($('input[name=quantity]').val());
            if (v < 2) {
                alert('不能再减少啦')
            } else {
                $('input[name=quantity]').val(v - 1);
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
        var w = $('body').width();
        $('#item-content img').each(function (index) {
            if ($(this).width() > w) {
                var h = ($(this).height() / $(this).width()) * w
                $(this).width(w);
                $(this).height(h);
            }
        })
        $('.btn-submit').on('click', function () {
            var id = $(this).attr('id');
            $('.help-block').html('');
            $('.form-group').removeClass('has-error');
            $('#post-form').ajaxSubmit({
                dataType: 'json',
                success: function (json) {
                    if (json.ret == 1100) {
                        $('#modal-login').modal('show');
                    } else if (json.ret == 0) {
                        if (id == 'add-to-cart') {
                            $('#modal-tip').find('.modal-body').html(
                                '<div class="text-center"><h4>恭喜</h4>' + json.msg +
                                '。</div>');
                            $('#modal-tip').find('.modal-title').html(
                                '<img src="/images/mall/mobile/icon-success.png" height="40" />'
                            );
                            $('#modal-tip').modal('show');
                        } else {
                            window.location.href = '{{url("/mall/cart")}}';
                        }
                        ajaxCart();
                    } else {
                        $('#modal-tip').find('.modal-body').html(
                            '<div class="text-center"><h4>抱歉</h4>' + json.msg +
                            '。</div>');
                        $('#modal-tip').find('.modal-title').html(
                            '<img src="/images/mall/mobile/icon-warning.png" height="40" />'
                        );
                        $('#modal-tip').modal('show');
                    }
                },
                error: function (xhr) {
                    var json = jQuery.parseJSON(xhr.responseText);
                    if (xhr.status == 200) {}

                    $.each(json, function (index, value) {
                        $('#form-group-' + index).addClass('has-error');
                        $('#help-' + index).html(value.join("<br/>"));
                    });
                }
            });
        })
        $('.btn-star').on('click', function () {
            var url = $(this).attr('data-url');
            $.post(url, {
                _token: window.Laravel.csrfToken
            }, function (json) {
                if (json.ret == 1100) {
                    $('#modal-login').modal('show');
                } else if (json.ret == 0) {
                    $('.btn-star').removeClass('btn-star-gray')

                } else {
                    $('.btn-star').addClass('btn-star-gray')
                }
            }, "JSON").fail(function () {
                $('#modal-tip').find('.modal-body').html(
                    '<div class="text-center"><h4>抱歉</h4>服务器发生错误，请重试。</div>');
                $('#modal-tip').find('.modal-title').html(
                    '<img src="/images/mall/mobile/icon-warning.png" height="40" />');
                $('#modal-tip').modal('show');
            })
        })
    })
</script>
@endsection