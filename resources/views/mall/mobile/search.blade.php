@extends('layouts.mall') @section('content')
<div id="main">
    <div class="container">
        <div class="row">
            <div class="mobile-item-categories">
                <ul class="list-group list-categories">
                    <li class="list-group-item {{ Request::input('cat_id') == null ?'active':'' }}"><a href="/mall/search">全部分类{!! Request::input('cat_id') == null ?'&gt;':'' !!}</a></li>
                    @foreach($categories as $category)
                    <li class="list-group-item {{ Request::input('cat_id') == $category->id ?'active':'' }}"><a href="/mall/search?cat_id={{ $category->id }}">{{$category->name}}{!! Request::input('cat_id') == $category->id ?'&gt;':'' !!}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="mobile-item-list">
                @include('mall.mobile.search_bar')
                <div class="row1 search-content">
                    <div class="content">
                        <div class="rows">
                            @if(count($items) > 0) @foreach($items as $k=>$item)
                            <div class="col-xs-6 mobile-item-list-single">
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
                <div class="" style="padding-left:25px;margin-bottom:60px;border-right: 5px solid #f0f0f0;">
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
        $("#main .container .search-content").css('margin-top',($('.search_bar').height()+26)+'px');
    })
</script>
@endsection