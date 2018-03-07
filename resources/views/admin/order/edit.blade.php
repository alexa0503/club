<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="">订单编号:{{$order->number}}</h4>
</div>
<div class="modal-body">
    @if($order->status == 0)
    {{ Form::open(array('url' => route('order.update',['id'=>$order->id]), 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'form-order')) }}
    <div class="form-group" id="form-group-logistics_name">
        <label for="logistics_name" class="col-md-2 col-xs-2 control-label">* 物流名称:</label>
        <div class="col-md-10 col-xs-10">
            <input class="form-control" type="text" value="" id="logistics_name" name="logistics_name">
            <label class="help-block" for="logistics_name" id="help-logistics_name"></label>
        </div>
    </div>
    <div class="form-group" id="form-group-logistics_code">
        <label for="logistics_code" class="col-md-2 col-xs-2 control-label">* 物流编号:</label>
        <div class="col-md-10 col-xs-10">
            <input class="form-control" type="text" value="" id="logistics_code" name="logistics_code">
            <label class="help-block" for="logistics_code" id="help-logistics_code"></label>
        </div>
    </div>
    <div class="form-group" id="form-group-mobile">
        <label for="remarks" class="col-md-2 col-xs-2 control-label"> 备注:</label>
        <div class="col-md-10 col-xs-10">
            <textarea id="remarks" name="remarks" class="form-control"></textarea>
            <label class="help-block" for="remarks" id="help-remarks"></label>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-10 col-xs-10 col-md-offset-2 col-xs-offset-2">
            <button type="submit" class="btn btn-primary">确 认</button>
        </div>
    </div>
    {{ Form::close() }}
    @elseif($order->status == 1)
        订单正在发货中
    @endif
</div>
