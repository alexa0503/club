@extends('layouts.mall') @section('content')
<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <ul class="list-group list-categories">
                    @foreach($categories as $category)
                    <li class="list-group-item {{ Request::input('cat_id') == $category->id ?'active':'' }}"><a href="/mall/search?cat_id={{ $category->id }}">{{$category->name}}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-xs-10">
                @include('mall.mobile.search_bar')
                <div class="row1">
                    <div class="content">
                        <div class="rows">
                            @if(count($items) > 0) @foreach($items as $k=>$item)
                            <div class="col-xs-6" style="margin-bottom:20px;height:200px;">
                                <a href="{{url('/mall/item/'.$item->id)}}">
                                    <img src="{{$item->thumb}}" class="img-responsive" />
                                </a>
                                <div style="height:40px;">
                                    <h4 style="font-size:12px">{{$item->name}}</h4>
                                </div>
                                <span>{{$item->point}}风迷币</span>
                            </div>
                            @endforeach
                            <div class="clearfix"></div>
                            @else
                            <h4>没有找到您需要的礼品，请点击
                                <a href="/mall" style=" display: inline;">这里</a>查看首页。</h4>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-left:20px;margin-bottom:60px;">
                    {!! $items->links() !!}
                </div>
            </div>
        </div>
    </div>
    @include('mall.mobile.car_bar',['active'=>'mall'])
</div>
@endsection @section('scripts')
<script>
    $().ready(function () {
        $('.slick').slick({
            'prevArrow': null,
            'nextArrow': null,
            'dots': true,
            'autoplay': true
        });
    })
</script>
@endsection