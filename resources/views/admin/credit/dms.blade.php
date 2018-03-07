@extends('layouts.admin')
@section('content')
    <div class="smart-widget">

        <div class="smart-widget-header">
            <form class="form-inline no-margin" action="/admin/credit/dms" method="GET">
                <div class="form-group"><input class="form-control datepicker" name="date1" placeholder="输入开始日期" value="{{Request::input('date1')}}" />-<input class="form-control datepicker" name="date2" placeholder="输入结束日期" value="{{Request::input('date2')}}" /></div>
                <div class="form-group">
                    <input type="text" placeholder="请输入用户名或者UID" value="{{Request::input('keywords')}}" class="form-control" name="keywords" id="keywords">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-sm">提交</button>
                    <button type="button" class="btn btn-primary btn-sm export">导出</button>
                    <span>共 {!! $rows->total() !!} 条记录</span>
                </div>
            </form>
        </div>
        <div class="smart-widget-inner">
            <div class="smart-widget-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>UID</th>
                        <th>用户名</th>
                        <th>SCORE ID</th>
                        <th>RONO</th>
                        <th>积分</th>
                        <th>风迷币</th>
                        <th>原因</th>
                        <th>消费时间</th>
                        <th>车型</th>
                        <th>经销商代码</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($rows as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td>{{$row->uid}}</td>
                            <td>{{$row->username}}</td>
                            <td>{{$row->score_id}}</td>
                            <td>{{$row->rono}}</td>
                            <td>{{$row->point}}</td>
                            <td>{{$row->coin}}</td>
                            <td>{{$row->reason}}</td>
                            <td>{{$row->spent_at}}</td>
                            <td>{{$row->model_code}}</td>
                            <td>{{$row->dealer}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $rows->appends($requestAll)->render() !!}
            </div>
        </div><!-- ./smart-widget-inner -->
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        $().ready(function () {
            $('.export').click(function(){
                var date1 = $('input[name=date1]').val();
                var date2 = $('input[name=date2]').val();
                var url = "{{url('admin/credit/exportdms')}}"+'?date1='+date1+'&date2='+date2;
                location.href=encodeURI(url);
            })
        });
    </script>
@endsection
