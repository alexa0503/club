@extends('layouts.admin') @section('content')
<div class="smart-widget">
    <div class="smart-widget-inner">
        <div class="smart-widget-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名称</th>
                        <th>QQ</th>
                        <th>手机</th>
                        <th>简介</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->qq}}</td>
                        <td>{{$item->tel}}</td>
                        <td>{{ $item->intro }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{route('dealer.edit',['id'=>$item->id])}}" class="btn btn-default btn-xs">编辑</a>
                            <a href="{{route('dealer.destroy',['id'=>$item->id])}}" class="btn destroy btn-default btn-xs">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $items->appends(Request::except('page'))->links() !!}
        </div>
    </div>
    <!-- ./smart-widget-inner -->
</div>
@endsection @section('scripts')
<script src="{{asset('js/jquery.form.js')}}"></script>
<script>
    $().ready(function () {
        $('.destroy').click(function () {
            var url = $(this).attr('href');
            var obj = $(this).parents('td').parent('tr');
            if (confirm('确认此操作?')) {
                $.ajax(url, {
                    dataType: 'json',
                    type: 'delete',
                    data: {
                        _token: window.Laravel.csrfToken
                    },
                    success: function (json) {
                        if (json.ret == 0) {
                            window.location.reload();
                        } else {
                            alert(json.msg);
                        }
                    },
                    error: function () {
                        alert('请求失败~');
                    }
                });
            }
            return false;
        })
    });
</script>
@endsection