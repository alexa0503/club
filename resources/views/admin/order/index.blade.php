@extends('layouts.admin')
@section('content')
    <div class="smart-widget">
        <div class="smart-widget-header">
            <form class="form-inline" action="/admin/order">
                <!--<div class="form-group"><input class="form-control" name="keywords" /></div>-->
                <div class="form-group"><input class="form-control datepicker" name="date1" placeholder="输入开始日期" value="{{Request::input('date1')}}" />-<input class="form-control datepicker" name="date2" placeholder="输入结束日期" value="{{Request::input('date2')}}" /></div>
                <div class="form-group"><input class="form-control" name="username" placeholder="输入用户名" value="{{Request::input('username')}}" /></div>
                <div class="form-group"><select class="form-control" name="status"><option value="">选择订单状态/全部</option><option value="0">待发货</option><option value="1">待配送</option><option value="2">已完成</option></select></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">查询</button>
                    <button type="button" class="btn btn-primary export">导出</button></div>
            </form>
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
                            <td colspan="5" style="background: #f5f5f5;">订单时间:{{$item->created_at}}<span style="margin-left: 20px;">订单号:{{$item->number}}</span>
                                <a data-url="{{route('order.edit',['id'=>$item->id])}}" href="javascript:;" title="点击发货" class="label label-info click-send" style="margin-left: 20px;">{{$order_statuses[$item->status]}}</a>
                            </td>
                        </tr>
                        <tr>
                            <td width="400">
                                <div style="position: relative;">
                                    <div class="pull-right" style="width: 280px;">
                                        <h5>{{$item->items[0]['name']}}</h5>
                                        @if(isset($item->items[0]['code']))<p>{!! str_replace(',',"<br/>",$item->items[0]['code']) !!}</p>@endif
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
                                        <p>x{{$_item['quantity']}}，{{$_item['point']}}风迷币</p>
                                        @if(isset($_item['code']))<p>{!! str_replace(',',"<br/>",$_item['code']) !!}</p>@endif
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
        $().ready(function () {
            $('select[name="status"]').val('{{Request::input("status")}}');
            $('.click-send').click(function () {
                var url = $(this).attr('data-url');
                $.ajax({
                    method:'GET',
                    url:url,
                    dataType:'html'
                }).done(function (html) {
                    $('#modal-verify').modal('show');
                    $('#modal-verify .modal-content').html(html).find('#form-order').ajaxForm({
                        dataType: 'json',
                        success: function (json) {
                            $('#modal-verify').modal('hide');
                            location.href = json.url;
                        },
                        error: function (xhr) {
                            var json = jQuery.parseJSON(xhr.responseText);
                            if (xhr.status == 200) {
                                $('#modal-verify').modal('hide');
                                location.href = json.url;
                            }
                            $('.help-block').html('');
                            $.each(json, function (index, value) {
                                $('#' + index).parents('.form-group').addClass('has-error');
                                $('#help-' + index).html(value);
                                //$('#'+index).next('.help-block').html(value);
                            });
                        }
                    });
                }).fail(function (jqXHR, textStatus) {
                    alert('请求失败');
                }).always(function() {
                    //alert( "complete" );
                });

                return false;
            })

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
        $('.export').click(function(){
            var date1 = $('input[name=date1]').val();
            var date2 = $('input[name=date2]').val();
            var username = $('input[name=username]').val();
            var status = $('select[name=status]').val();
            var url = "{{url('admin/order/export')}}"+'?date1='+date1+'&date2='+date2+'&username='+username+'&status='+status;
            location.href=encodeURI(url);
        })
    </script>
@endsection
