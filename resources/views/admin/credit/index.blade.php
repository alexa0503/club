@extends('layouts.admin')
@section('content')
<div class="smart-widget">

	<div class="smart-widget-header">
		<form class="form-inline no-margin" method="GET">
            <div class="form-group">
                <input type="text" placeholder="请输入用户名或者UID" value="{{Request::input('keywords')}}" class="form-control" name="keywords" id="keywords">
            </div><!-- /form-group -->
            <div class="form-group"><button type="submit" class="btn btn-primary btn-sm">提交</button></div>
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
			        	<th>积分</th>
			        	<th>风迷币</th>
			        	<th>原因</th>
			        	<th>描述</th>
			        	<th>创建时间</th>
	        		</tr>
	      		</thead>
	      		<tbody>
                    @foreach($rows as $row)
		        	<tr>
			          	<td>{{$row->logid}}</td>
						<td>{{$row->uid}}</td>
                        <td>{{$row->username}}</td>
						<td>{{$row->extcredits1}}</td>
						<td>{{$row->extcredits4}}</td>
						<td>{{$row->title}}</td>
						<td>{{$row->text}}</td>
						<td>{{Carbon\Carbon::createFromTimestamp($row->dateline)->toDateTimeString()}}</td>
		        	</tr>
                    @endforeach
		      	</tbody>
		    </table>
            {!! $rows->links() !!}
		</div>
	</div><!-- ./smart-widget-inner -->
</div>
@endsection
