@extends('layouts.admin')
@section('content')
    <div class="smart-widget">
        <div class="smart-widget-header">
            Striped rows
        </div>
        <div class="smart-widget-inner">
            <div class="smart-widget-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ps.点击订单状态可操作</th>
                        <th>用户名</th>
                        <th>总量</th>
                        <th>总风迷币</th>
                        <th>收货信息</th>
                    </tr>
                    </thead>
                    @foreach($items as $item)
                        <tbody>
                        <tr>
                            <td colspan="5" style="background: #f5f5f5;">订单时间:{{$item->created_at}}<span style="margin-left: 20px;">订单号:{{date('YmdHi',strtotime($item->created_at))}}{{$item->id}}</span>
                                <a href="javascript:;" title="点击发货" class="label label-info" style="margin-left: 20px;">{{$order_statuses[$item->status]}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td width="400">
                                <div style="position: relative;">
                                    <div class="pull-right" style="width: 280px;">
                                        <h5>{{$item->items[0]['name']}}</h5>
                                        <p>{{$item->items[0]['color']}}</p>
                                        <p>x{{$item->items[0]['quantity']}}，{{$item->items[0]['point']}}风迷币</p>
                                    </div>
                                    <div style="width: 100px;">
                                        <img src="{{$item->items[0]['image']}}" width="100"/>
                                    </div>
                                </div>

                            </td>
                            <td rowspan="{{count($item->items)}}}">{{$item->user->username}}</td>
                            <td rowspan="{{count($item->items)}}}">{{$item->quantity}}</td>
                            <td rowspan="{{count($item->items)}}}">{{$item->point}}</td>
                            <td rowspan="{{count($item->items)}}}">{{$item->receiver}} {{$item->mobile}}/{{$item->telephone?:'--'}} {{$item->address}}</td>
                        </tr>
                        @foreach($item->items as $k=>$_item)
                        @if($k>0)
                        <tr>
                            <td width="400">
                                <div style="position: relative;">
                                    <div class="pull-right" style="width: 280px;">
                                        <h5>{{$_item['name']}}</h5>
                                        <p>{{$_item['color']}}</p>
                                        <p>x{{$_item['quantity']}}，{{$_item['point']}}风迷币</p>
                                    </div>
                                    <div style="width: 100px;">
                                        <img src="{{$_item['image']}}" width="100"/>
                                    </div>
                                </div>

                            </td>
                        </tr>
                        @endif
                        @endforeach
                        </tbody>
                    @endforeach
                </table>
                {!! $items->links() !!}
            </div>
        </div><!-- ./smart-widget-inner -->
    </div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
            $('.destroy').click(function(){
                var url = $(this).attr('href');
                var obj = $(this).parents('td').parent('tr');
                if( confirm('确认此操作?')){
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
            })
            $('.restore').click(function(){
                var url = $(this).attr('href');
                if( confirm('确认此操作?')) {
                    $.ajax(url, {
                        dataType: 'json',
                        type: 'get',
                        data: {_token: window.Laravel.csrfToken},
                        success: function (json) {
                            if (json.ret == 0) {
                                window.location.reload();
                            }
                            else {
                                alert(json.msg);
                            }
                        },
                        error: function () {
                            alert('请求失败~');
                        }
                    });
                }
                return false;
            });
        })
    </script>
@endsection
