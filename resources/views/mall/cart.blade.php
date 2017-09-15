@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container">
            <h4>我的购物车</h4>
            <div class="addr">
                @if(count($addresses) > 0 )
                <p style="margin-left: 20px;">收货地址：</p>
                <ul class="addrList">
                    @foreach($addresses as $k=>$address)
                    <li>
                        <input value="{{$address->id}}" type="radio" style="margin:0 10px;" name="address" @if($k==0)checked="checked"@endif id="address{{$k}}"  />
                        <div class="userAddr {{$k == 0 ?'nowAddr':''}}"><label style="margin: 0px;font-weight: normal" for="address{{$k}}">{{$address->province}} {{$address->city}} {{$address->district}}{{$address->detail}}（{{$address->name}}收）{{$address->mobile}}</label><a href="javascript:;" class="upAddr" data-url="{{url('/mall/address/'.$address->id)}}">修改地址</a><a href="javascript:;" class="delAddr" data-url="{{url('/mall/address/'.$address->id)}}">删除</a>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
                <button style="margin-left: 50px;border: 0;background: red;color:#fff;" id="btn-add-address">@if(count($addresses) <=0 )创建地址@else使用新地址@endif</button>
            </div>
            <div style="width:100%;height:5px;background:red;margin:30px 0;z-index:1;"></div>
            <div class="shangpinbox">
                <ul class="shangpin">
                    @foreach($carts as $cart)
                    <li class="shoplist" style="position: relative;">
                        <input type="checkbox" value="{{$cart->id}}" class="shopChek" name="id[]" checked="checked" />
                        <div class="shopImg">
                            @if($cart->item->images > 0)
                            <img style="width:100%;height:100%;" src="{{asset($cart->item->images[0])}}" alt="" />
                            @endif
                        </div>
                        <div class="shopTitle">{{$cart->item->name}}</div>
                        <div class="toolbox">
                            <div class="sub" data-url="{{url('/mall/cart/'.$cart->id)}}">-</div>
                            <div class="text"><input type="text" data-url="{{url('/mall/cart/'.$cart->id)}}"value="{{$cart->quantity}}" name="quantity[]" /></div>
                            <div class="add" data-url="{{url('/mall/cart/'.$cart->id)}}">+</div>
                            <div class="jinbi">{{$cart->item->point}}风迷币</div> <a href="javascript:;" data-url="{{url('/mall/cart/'.$cart->id)}}" class="remove">删除</a>
                        </div>
                        <input type="hidden" name="point[]" value="{{$cart->item->point}}">
                    </li>
                    @endforeach
                    @if(count($carts) <= 0)
                    <li class="shoplist" style="text-align: center;color: red;padding-top:40px;">购物车里没有商品哦~<a href="{{url('/mall')}}">点击这里</a>去挑选。</li>
                    @endif
                </ul>
                <div class="shopDi">
                    <div class="dibox">
                        <input type="checkbox" class="allSe" checked="checked" />
                        <div class="allSeT">全选</div>
                        <div class="removeAll">删除选中的商品</div>
                        <div class="shopSum">合计：</div>
                        <div class="Total"><span></span>风迷币</div>
                    </div>
                    <button class="jiesuan">结算</button>
                </div>
            </div>
            <div style="height:77px;width:100%;"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
            $.fn.cartCalculate = function() {
                var amount = 0
                $('.shangpin li').each(function (index) {
                    if ( $(this).find('input[name="id[]"]:checked').val() ){
                        var quantity = parseInt($(this).find('input[name="quantity[]"]').val());
                        var point = parseInt($(this).find('input[name="point[]"]').val());
                        //alert(quantity);
                        var count = quantity*point;
                        if (!count){
                            count = 0;
                        }
                        amount += count;
                    }

                });
                //alert(amount);
                $('.Total').find('span').html(amount);
            }

            $('#btn-add-address').on('click',function () {
                $('#modal-address').modal('show');
            });
            $('.upAddr').on('click',function () {
                var url = $(this).attr('data-url');
                $.getJSON(url, function (json) {
                    if (json.ret == 0){
                        $('#address-form').find('input[name=name]').val(json.data.name);
                        $('#address-form').find('input[name=mobile]').val(json.data.mobile);
                        $('#address-form').find('input[name=detail]').val(json.data.detail);
                        $('#address-form').find('input[name=telphone]').val(json.data.telphone);
                        $('#address-form').find('input[name=id]').val(json.data.id);
                        //province_id = json.data.province_id;
                        //city_id = json.data.city_id;
                        //district_id = json.data.district_id;
                        $('#province').val(json.data.province).trigger("change");
                        $('#city').val(json.data.city).trigger("change");
                        $('#district').val(json.data.district).trigger("change");



                        $('#modal-address').modal('show');
                    }
                    else{
                        alert(json.msg);
                    }
                })
                //
            });
            $('.delAddr').on('click',function () {
                if (confirm('确认删除？')){
                    var url = $(this).attr('data-url');
                    $.ajax(url, {
                        dataType: 'json',
                        type: 'delete',
                        data: {_token:window.Laravel.csrfToken},
                        success: function(json){
                            if(json.ret == 0){
                                window.location.reload();
                            }
                            else{
                                alert(json.msg);
                            }
                        },
                        error: function(){
                            alert('请求失败~');
                        }
                    });
                }
                return false;
            });

            $().cartCalculate();
            $('.add').click(function(){
                var url = $(this).attr('data-url');
                var nowval = parseInt($(this).siblings('.text').find('input').val());
                var obj = $(this).siblings('.text').find('input');
                $.ajax(url, {
                    dataType: 'json',
                    type: 'put',
                    data: {_token:window.Laravel.csrfToken,quantity:nowval+1},
                    success: function(json){
                        if(json.ret == 0){
                            obj.val(nowval+1);
                            $().cartCalculate();
                        }
                        else{
                            alert(json.msg);
                        }
                    },
                    error: function(){
                        alert('请求失败~');
                    }
                });
            });
            $('.sub').click(function(){
                var url = $(this).attr('data-url');
                var nowval = parseInt($(this).siblings('.text').find('input').val());
                var obj = $(this).siblings('.text').find('input');
                if(nowval>0){
                    $.ajax(url, {
                        dataType: 'json',
                        type: 'put',
                        data: {_token:window.Laravel.csrfToken,quantity:nowval-1},
                        success: function(json){
                            if(json.ret == 0){
                                obj.val(nowval-1);
                                $().cartCalculate();
                            }
                            else{
                                alert(json.msg);
                            }
                        },
                        error: function(){
                            alert('请求失败~');
                        }
                    });
                }
                else{
                    alert('不能再减少了');
                }

            });
            $('input[name="quantity[]"]').on('change',function () {
                var url = $(this).attr('data-url');
                var quantity = $(this).val();
                $.ajax(url, {
                    dataType: 'json',
                    type: 'put',
                    data: {_token:window.Laravel.csrfToken,quantity:quantity},
                    success: function(json){
                        if(json.ret == 0){
                            $().cartCalculate();
                        }
                        else{
                            alert(json.msg);
                        }
                    },
                    error: function(){
                        alert('请求失败~');
                    }
                });
            });
            $('.remove').click(function(){
                var url = $(this).attr('data-url');
                var obj = $(this).parent().parent();
                $.ajax(url, {
                    dataType: 'json',
                    type: 'delete',
                    data: {_token:window.Laravel.csrfToken},
                    success: function(json){
                        if(json.ret == 0){
                            //obj.remove();
                            window.location.reload();
                        }
                        else{
                            alert(json.msg);
                        }
                    },
                    error: function(){
                        alert('请求失败~');
                    }
                });
            });
            $('input[name="address"]').click(function(){
                $('.addrList .userAddr').removeClass('nowAddr');
                $(this).siblings('.userAddr').addClass('nowAddr');
            });
            $(".shopDi .allSe").change(function(event) {
                var ti = $(this).is(':checked');
                //alert(ti);
                $('input[name="id[]"]').each(function(e){
                    //$(this).attr("checked",ti.attr("checked"));
                    $(this).prop("checked",ti);
                });
                $().cartCalculate();
            });
            $('.removeAll').click(function(){
                $('input[name="id[]"]').each(function(e){
                    //$(this).attr("checked",ti.attr("checked"));
                    if($(this).prop("checked")){
                        $(this).parent().remove();
                    }
                });
                $().cartCalculate();
            })
            $('.jiesuan').on('click',function () {
                var url = '{{url("/mall/order")}}';
                var address_id = $('input[name="address"]:checked').val();
                //var id = $('input[name="id[]"]:checked').val();
                var id = new Array;
                $('input[name="id[]"]:checked').each(function(e){
                    id.push($(this).val());
                })
                //console.log(id);
                $.ajax(url, {
                    dataType: 'json',
                    type: 'post',
                    data: {_token:window.Laravel.csrfToken,address_id:address_id,id:id},
                    success: function(json){
                        if(json.ret == 0){
                            //alert(json.msg);
                            $('#modal-tip').find('.modal-body').html(json.msg);
                            $('#modal-tip').find('.modal-title').html('恭喜');
                            $('#modal-tip').modal('show').on('hidden.bs.modal', function () {
                                // do something…
                                window.location.href = '{{url("/mall/order")}}';
                            });
                        }
                        else{
                            alert(json.msg);
                        }
                    },
                    error: function(){
                        alert('请求失败~');
                    }
                });
            })
        })
    </script>
@endsection
