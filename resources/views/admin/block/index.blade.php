@extends('layouts.admin')
@section('content')
<div class="smart-widget">
	<div class="smart-widget-inner">
		<div class="smart-widget-body">
            <table id="basic-datatables" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>区块</th>
                    <th>标题</th>
                    <th>排序</th>
                    <th>是否发布</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($rows as $row)
                <tr>
                    <td>{{ $blocks[$row->name] }}</td>
                    <td>{{ $row->title }}</td>
                    <td>{{ $row->sort_id }}</td>
                    <td>{{ $row->is_posted == '1' ? '是' : '否' }}</td>
                    <td>{{ $row->created_at }}</td>
                    <td>
                        <a href="{{route('page.block.edit',['page'=>$row->page_id,'id'=>$row->id])}}" class="btn btn-default btn-sm">编辑</a>
                        <a href="{{route('page.block.destroy',['page'=>$row->page_id,'id'=>$row->id])}}" class="btn btn-default btn-sm">删除</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {!! $rows->links() !!}
		</div>
	</div><!-- ./smart-widget-inner -->
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function() {
    $('.delete').click(function(){
        var url = $(this).attr('href');
        var obj = $(this).parents('td').parent('tr');
        if( confirm('该操作无法返回,是否继续?')){
            $.ajax(url, {
                dataType: 'json',
                type: 'delete',
                success: function(json){
                    if(json.ret == 0){
                        obj.remove();
                    }
                },
                error: function(){
                    alert('请求失败~');
                }
            });
        }
        return false;
    })
    $('.update').click(function(){
        var url = $(this).attr('href');
        var obj = $(this);
        $.ajax(url, {
            dataType: 'json',
            success: function(json){
                if(json.ret == 0){
                    location.reload();
                }
            },
            error: function(){
                alert('请求失败~');
            }
        });
        return false;
    })
});
</script>
@endsection
