@extends('layouts.admin')
@section('content')
    <div class="smart-widget">
        <div class="smart-widget-inner">
            <div class="smart-widget-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户名</th>
                        <th>车架号</th>
                        <th>推荐用户</th>
                        <th>状态</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->user->username}}</td>
                            <td>{{$item->frame_number}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->status == 0 ? '待认证' : '已认证'}}</td>
                            <td>{{$item->created_at}}</td>
                            <td><a class="btn btn-sm btn-primary" href="">认证</a></td>
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
@endsection
