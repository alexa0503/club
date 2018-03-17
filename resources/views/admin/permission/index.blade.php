@extends('layouts.admin') @section('content')
<div class="smart-widget">
    <div class="smart-widget-header">
        <form class="form-inline" action="/admin/permission">
            <div class="form-group">
                <input class="form-control" name="keywords" placeholder="输入关键词" value="{{Request::input('keywords')}}" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">查询</button>
            </div>
        </form>
    </div>
    <div class="smart-widget-inner">
        <div class="smart-widget-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>登录名</th>
                        <th>Email</th>
                        <th>权限</th>
                        <th>角色</th>
                        <th>最后登录</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{ $item->permission_names }}</td>
                        <td>{{ $item->role_names }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a href="{{route('permission.edit',['id'=>$item->id])}}" class="btn btn-default btn-xs">编辑</a>
                            <a href="{{route('permission.destroy',['id'=>$item->id])}}" class="btn destroy btn-default btn-xs">删除</a>
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