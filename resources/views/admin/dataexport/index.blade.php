@extends('layouts.admin')
@section('content')
    <div class="smart-widget">
        <div class="smart-widget-header">
            <form class="form-inline">
                <!--<div class="form-group"><input class="form-control" name="keywords" /></div>-->
                <!-- <div class="form-group"><input class="form-control datepicker" name="date1" placeholder="输入开始日期" value="{{Request::input('date1')}}" />-<input class="form-control datepicker" name="date2" placeholder="输入结束日期" value="{{Request::input('date2')}}" /></div> -->
                <div class="form-group">
                    <button type="button" class="btn btn-primary export">导出</button></div>
            </form>
        </div>
    </div>
@endsection

@section('popup')
    <div class="modal fade" id="modal-verify" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        $('.export').click(function(){
            var date1 = $('input[name=date1]').val();
            var date2 = $('input[name=date2]').val();
            var url = "{{url('admin/dataexport/export')}}"+'?date1='+date1+'&date2='+date2;
            location.href=encodeURI(url);
        })
    </script>
@endsection
