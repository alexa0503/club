@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container" style="padding-bottom: 40px;">
            <h4>我的订单</h4>
            <div style="width:100%;height:5px;background:red;margin:30px 0;z-index:1;"></div>
            @if(count($orders) <= 0)
                <div class="dingdanbox" style="margin-top: 10px;">您还没有任何订单信息</div>
            @endif
            @foreach($orders as $order)
            <div class="dingdanbox" style="margin-top: 10px;">
                <table class="table" style="width:100%;border:#ccc solid 1px;margin-bottom: 0px; " cellpadding="0" cellspacing="0" border="1">
                    <thead>
                    <tr style="background: #f5f5f5;">
                        <th width="400">{{$order->created_at}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;订单号：{{date('YmdHi',strtotime($order->created_at))}}{{$order->id}}</th>
                        <th>数量</th>
                        <th>地址</th>
                        <th>联系方式</th>
                        <th>总金额</th>
                        <th>状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="position:relative;height:90px;">
                            <img style="height:71px;width:71px;display:block;position:absolute;top:10px;left:10px;" src="{{$order->items[0]['image']}}" alt="">
                            <div style="overflow: hidden;height:71px;width:297px;position:absolute;left:0;top:6px;left:92px;">{{$order->items[0]['name']}}@if($order->items[0]['color']!='default')<br/>{{$order->items[0]['color']}}@endif @if(isset($order->items[0]['code']))<br/>{!! str_replace(',','<br/>',$order->items[0]['code']) !!}@endif</div>
                        </td>
                        <td>{{$order->quantity}}</td>
                        <td rowspan="{{count($order->items)}}">{{$order->address}}</td>
                        <td rowspan="{{count($order->items)}}">{{$order->receiver}}<br />{{$order->mobile}}</td>
                        <td rowspan="{{count($order->items)}}">{{$order->point}}风迷币</td>
                        <td rowspan="{{count($order->items)}}">@if(isset($order->items[0]['code'])){{ '完成'  }}@else{{$order_statuses[$order->status]}}@endif</td>
                    </tr>
                    @foreach($order->items as $k=>$item)
                        @if($k>0)
                    <tr>
                        <td style="position:relative;height:90px;">
                            <img style="height:71px;width:71px;display:block;position:absolute;top:10px;left:10px;" src="{{$item['image']}}" alt="">
                            <div style="overflow: hidden;height:71px;width:297px;position:absolute;left:0;top:6px;left:92px;">{{$item['name']}}@if($item['color']!='default')<br/>{{$item['color']}}@endif @if(isset($item['code']))<br/>{!! str_replace(',','<br/>',$item['code']) !!}@endif</div>
                        </td>
                        <td>{{$item['quantity']}}</td>
                        @endif
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
        })
    </script>
@endsection