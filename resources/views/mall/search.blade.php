@extends('layouts.mall')
@section('content')
<div id="main">
    <div class="container">
        <div class="row">
            @if(count($kvs)>0)
            <div id="kv">
                <a href="{{$kvs[0]->link}}"><img src="{{$kvs[0]->image}}" width="1090"/></a>
                <div id="kv-text">
                    <h2>{{$kvs[0]->title}}</h2>
                    <p>{{$kvs[0]->description}}</p>
                </div>
            </div>
            @endif
            <div class="rows">
                <ol class="breadcrumb">
                  <li><a href="{{url('/')}}">东风风光</a></li>
                  <li><a href="{{url('mall')}}">礼品商城</a></li>
                  @if ( $category )
                  <li><a href="{{url('mall/category'.$category->id)}}">{{$category->name}}</a></li>
                  @endif
                </ol>
            </div>
            @include('mall.search_bar',['categories'=>$categories])
            <div class="row1">
                <div class="top-border hidden-xs"></div>
                <div class="top">
                    <span>@if ( $category ){{$category->name}}@else{{'搜索结果'}}@endif</span>
                </div>
                <div class="caret"></div>
                <div class="content" style="height: 300px;">
                    <div class="rows">
                    @if(count($items) > 0)
                        @foreach($items as $k=>$item)
                        <div class="col-md-2  col-xs-6 {{ ( $k%6 != 5 and $k != count($items)-1 ) ?'border':''}}" style="height:257px;margin-bottom:20px;">

                            <a href="{{url('/mall/item/'.$item->id)}}"><img src="{{$item->thumb}}" width="162" height="177" /></a>
                            <div style="height:40px;"><h4>{{$item->name}}</h4></div>
                            <span>{{$item->point}}风迷币</span>
                        </div>
                        @endforeach
                    @else
                    <h4>没有找到您需要的礼品，请点击<a href="/mall" style=" display: inline;">这里</a>查看首页。</h4>
                    @endif
                    </div>
                </div>
            </div>
            <div class="rows" style="padding-left:20px;">
                {!! $items->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
            $('.slick').slick({
                'prevArrow':null,
                'nextArrow':null,
                'dots':true,
                'autoplay':true
            });
        })
    </script>
@endsection
