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
                        <th>身份证号</th>
                        <th>车型</th>
                        <th>创建时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->user->username}}</td>
                            <td>{{$item->frame_number}}</td>
                            <td>{{$item->id_card}}</td>
                            <td>{{$item->model_code}}</td>
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
@endsection
