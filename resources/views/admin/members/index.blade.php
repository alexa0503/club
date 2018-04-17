@extends('layouts.admin')
@section('content')
    <div class="smart-widget">
        <div class="smart-widget-header">
            <form class="form-inline" action="/admin/members">
                <!--<div class="form-group"><input class="form-control" name="keywords" /></div>-->
                <div class="form-group"><input class="form-control datepicker" name="date1" placeholder="输入开始日期" value="{{Request::input('date1')}}" />-<input class="form-control datepicker" name="date2" placeholder="输入结束日期" value="{{Request::input('date2')}}" /></div>
                <div class="form-group">
                    <select class="form-control" id="datafrom" name="datafrom" value="{{Request::input('datafrom')}}">
                        <option value="">选择数据来源/全部</option>
                        <option value="1">CRM</option>
                        <option value="2">车友会</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" id="group" name="group" value="{{Request::input('group')}}">
                        <option value="">请选择/全部</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->groupid }}" {!! Request::input('group') == $group->groupid ? 'selected="selected"' : '' !!}>{{ $group->grouptitle }}</option>
                        @endforeach
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
                        <th>会员名</th>
                        <th>会员等级</th>
                        <th>积分</th>
                        <th>风迷币</th>
                        <th>认证车架号</th>
                        <th>认证姓名</th>
                        <th>认证车型</th>
                        <th>注册时间</th>
                        <th>邮箱</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->uid}}</td>
                            <td>{{$item->username}}</td>
                            <td>{{$item->grouptitle}}</td>
                            <td>{{$item->extcredits1}}</td>
                            <td>{{$item->extcredits4}}</td>
                            <td>{{$item->frame_number}}</td>
                            <td>{{$item->id_card}}</td>
                            <td>{{$item->model_code}}</td>
                            <td>{{Carbon\Carbon::createFromTimestamp($item->regdate)->toDateTimeString()}}</td>
                            <td>{{$item->email}}</td>
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
    @section('scripts')
<script src="{{asset('js/jquery.form.js')}}"></script>
<script>
    $().ready(function () {
        $('select[name="datafrom"]').val('{{Request::input("datafrom")}}');

        $('.export').click(function(){
            var date1 = $('input[name=date1]').val();
            var date2 = $('input[name=date2]').val();
            var datafrom = $('#datafrom').val();
            var url = "{{url('admin/members/export')}}"+'?date1='+date1+'&date2='+date2+'&datafrom='+datafrom;
            location.href=encodeURI(url);
        })
    });
</script>
@endsection
