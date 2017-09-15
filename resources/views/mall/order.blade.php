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
            @php
            $has_address = false;
            @endphp
            <div class="dingdanbox" style="margin-top: 10px;">
                <table class="table table-bordered">
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
                        @foreach($order->items as $k=>$item)
                        @if(isset($item['type']) AND $item['type']==1)
                        @for($i=0;$i<$item['quantity'];$i++)
                        @if(isset($item['coupon'][$i]))
                        <tr>
                            <td style="position:relative;height:90px;">
                                <img style="height:71px;width:71px;display:block;position:absolute;top:10px;left:10px;" src="{{$item['image']}}" alt="">
                                <div style="overflow: hidden;height:71px;width:297px;position:absolute;left:0;top:6px;left:92px;">{{$item['name']}}
                                    <br/>
                                    @if(isset($item['coupon'])){{$item['coupon'][$i]['code']}}<br/><span style="font-size:12px;color:#999;">使用期限：{{$item['coupon'][$i]['valid_date']}}</span>@endif
                                </div>
                            </td>
                            <td>1</td>
                            <td colspan="2"></td>
                            <td>{{$item['point']}}</td>
                            <td>@if(isset($item['coupon'])){{ $item['coupon'][$i]['status']==2 ? '已使用': '未使用'}}@endif</td>
                        </tr>
                        @endif
                        @endfor
                        @php
                        $has_address = false;
                        @endphp
                        @else
                        <tr>
                            <td style="position:relative;height:90px;">
                                <img style="height:71px;width:71px;display:block;position:absolute;top:10px;left:10px;" src="{{$item['image']}}" alt="">
                                <div style="overflow: hidden;height:71px;width:297px;position:absolute;left:0;top:6px;left:92px;">{{$item['name']}} @if(isset($item['code']))<br/>{!! str_replace(',','<br/>',$item['code']) !!}@endif</div>
                            </td>
                            <td>{{$item['quantity']}}</td>
                            @if($has_address == true)
                            <td colspan="4"></td>
                            @else
                            <td>{{$order->address}}</td>
                            <td>{{$order->receiver}}<br />{{$order->mobile}}</td>
                            <td>{{$order->point}}风迷币</td>
                            <td>{{$order_statuses[$order->status]}}</td>
                            @php
                            $has_address = true;
                            @endphp
                            @endif
                        </tr>
                        @endif
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
