@extends('layouts.admin')
@section('content')
    <div class="smart-widget">
        <div class="smart-widget-inner">
            <div class="smart-widget-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户</th>
                        <th>商品</th>
                        <th>颜色</th>
                        <th>数量</th>
                        <th>风迷币</th>
                        <th>收货人</th>
                        <th>手机/固定电话</th>
                        <th>详细地址</th>
                        <th>提交时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->user->username}}</td>
                            <td>{{$item->item->name}}</td>
                            <td>{{$item->color}}</td>
                            <td>{{$item->quantity}}</td>
                            <td>{{$item->point}}</td>
                            <td>{{$item->receiver}}</td>
                            <td>{{$item->mobile}}/{{$item->telephone?:'--'}}</td>
                            <td>{{$item->address}}</td>
                            <td>{{$item->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
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
