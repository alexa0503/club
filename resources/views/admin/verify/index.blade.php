@extends('layouts.admin')
@section('content')
    <div class="smart-widget">
        <div class="smart-widget-header">
            <form class="form-inline" action="/admin/verify">
                <!--<div class="form-group"><input class="form-control" name="keywords" /></div>-->
                <div class="form-group"><input class="form-control datepicker" name="date1" placeholder="输入开始日期" value="{{Request::input('date1')}}" />-<input class="form-control datepicker" name="date2" placeholder="输入结束日期" value="{{Request::input('date2')}}" /></div>
                <div class="form-group">
                    <select class="form-control" id="model_code" name="model_code" value="{{Request::input('model_code')}}">
                        <option value="">选择车型/全部</option>
                        @foreach($model_codes as $code)
                            <option value="{{$code->model_code}}">{{$code->model_code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="datafrom" name="datafrom" value="{{Request::input('datafrom')}}">
                        <option value="">选择数据来源/全部</option>
                        <option value="1">CRM</option>
                        <option value="2">车友会</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">查询</button>
                    <button type="button" class="btn btn-primary export">导出</button>
                    <span>共 {!! $items->total() !!} 条记录</span>
                </div>
            </form>
        </div>
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
                {!! $items->appends($requestAll)->render() !!}
            </div>
        </div><!-- ./smart-widget-inner -->
    </div>
@endsection
@section('scripts')
<script src="{{asset('js/jquery.form.js')}}"></script>
<script>
    $().ready(function () {
        $('select[name="model_code"]').val('{{Request::input("model_code")}}');
        $('select[name="datafrom"]').val('{{Request::input("datafrom")}}');

        $('.export').click(function(){
            var date1 = $('input[name=date1]').val();
            var date2 = $('input[name=date2]').val();
            var model_code = $('#model_code').val();
            var datafrom = $('#datafrom').val();
            var url = "{{url('admin/verify/export')}}"+'?date1='+date1+'&date2='+date2+'&model_code='+model_code+'&datafrom='+datafrom;
            location.href=encodeURI(url);
        })
    });
</script>
@endsection
