@extends('layouts.admin')
@section('content')
<div class="smart-widget">
	<div class="smart-widget-inner">
		<div class="smart-widget-body">
			<table class="table table-striped">
	      		<thead>
	        		<tr>
                        <th>产品编号</th>
			          	<th>产品名</th>
                        <th>产品性质</th>
                        <th>产品分类</th>
                        <th>经销商</th>
			          	<th>已售</th>
			          	<th>市场价</th>
			          	<th>风迷币</th>
						<th>爆款推荐</th>
						<th>热门兑换</th>
						<th>状态</th>
			          	<th>操作</th>
	        		</tr>
	      		</thead>
	      		<tbody>
                    @foreach($items as $item)
		        	<tr>
			          	<td>{{$item->product_code}}</td>
			          	<td>{{$item->name}}</td>
                        <td>{{$item->type==1?'优惠券':'普通商品'}}</td>
			          	<td>{{ $item->category ? $item->category->name : '--'}}</td>
			          	<td>{{ $item->dealer ? $item->dealer->name : '--'}}</td>
			          	<td>{{$item->sold_quantity}}</td>
			          	<td>{{$item->price}}</td>
			          	<td>{{$item->point}}</td>
						<td>{{$item->feature1 > 0 ? $item->feature1 : '--' }}</td>
						<td>{{$item->feature2 > 0 ? $item->feature2 : '--' }}</td>
						<td>{!! $item->deleted_at ? '<span class="text-danger">已删</span>' : '正常' !!}</td>
                        <td>

						@if($item->deleted_at)
								<a href="{{route('item.restore',['id'=>$item->id])}}" class="btn restore btn-default btn-xs">恢复</a>
						@else
								<a href="{{route('item.edit',['id'=>$item->id])}}" class="btn btn-default btn-xs">编辑</a>
								<a href="{{route('item.destroy',['id'=>$item->id])}}" class="btn destroy btn-default btn-xs">删除</a>
						@endif
						</td>
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
<script>
$().ready(function () {
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
</script>
@endsection
