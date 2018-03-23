@extends('layouts.mall') @section('content')
<div id="main">
    <div class="container">
        <div class="row">
            @if(count($kvs)>0)
            <div id="kv">
                <a href="{{$kvs[0]->link}}">
                    <img src="{{ $kvs[0]->image }}" />
                </a>
                <div id="kv-text">
                    <h2>{{$kvs[0]->title}}</h2>
                    <p>{{$kvs[0]->description}}</p>
                </div>
            </div>
            @endif

            <div id="bs-mall">
                <ul id="indexTabs" class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#latest" id="latest-tab" role="tab" data-toggle="tab" aria-controls="latest" aria-expanded="true">最新礼品</a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#hot" id="hot-tab" role="tab" data-toggle="tab" aria-controls="hot" aria-expanded="true">热门兑换</a>
                    </li>
                    <li role="presentation" class="">
                        <a href="#mine" role="tab" id="mine-tab" data-toggle="tab" aria-controls="mine" aria-expanded="true">我能兑换</a>
                    </li>
                    <li role="presentation" class="">
                        <a href="{{ url('mall/search') }}" >全部商品</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="latest" aria-labelledby="latest-tab">
                        <div class="content">
                            <div class="row1">
                                <div class="content">
                                    <div class="rows">
                                        @foreach($latest as $k=>$item)
                                        <div class="col-xs-6">
                                            <a href="{{url('/mall/item/'.$item->id)}}">
                                                <img src="{{$item->thumb}}" width="162" height="177" />
                                            </a>
                                            <div style="height:40px;">
                                                <h4>{{$item->name}}</h4>
                                            </div>
                                            <span>{{$item->point}}风迷币</span>
                                            <div class="mobile-btns center-block">
                                                <a class="btn btn-view" href="{{url('/mall/item/'.$item->id)}}">查看详情</a>
                                                
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="more-text">
                                        <a href="/mall/search?keywords=&point_min=&point_max=&cat_id=&order_name=created_at&order_type=DESC">More&gt;&gt;</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="hot" aria-labelledby="hot-tab">
                        <div class="content">
                            <div class="row1">
                                <div class="content" style="height: 300px;">
                                    <div class="rows">
                                        @foreach($features3 as $k=>$item)
                                        <div class="col-xs-6">
                                            <a href="{{url('/mall/item/'.$item->id)}}">
                                                <img src="{{$item->thumb}}" width="162" height="177" />
                                            </a>
                                            <div style="height:40px;">
                                                <h4>{{$item->name}}</h4>
                                            </div>
                                            <span>{{$item->point}}风迷币</span>
                                            <div class="mobile-btns center-block">
                                                <a class="btn btn-view" href="{{url('/mall/item/'.$item->id)}}">查看详情</a>
                                               
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="mine" aria-labelledby="mine-tab">
                        <div class="content">
                            <div class="row1">
                                <div class="content" style="height: 300px;">
                                    <div class="rows">
                                        @foreach($features2 as $k=>$item)
                                        <div class="col-xs-6">
                                            <a href="{{url('/mall/item/'.$item->id)}}">
                                                <img src="{{$item->thumb}}" width="162" height="177" />
                                            </a>
                                            <div style="height:40px;">
                                                <h4>{{$item->name}}</h4>
                                            </div>
                                            <span>{{$item->point}}风迷币</span>
                                            <div class="mobile-btns center-block">
                                                <a class="btn btn-view" href="{{url('/mall/item/'.$item->id)}}">查看详情</a>
                                                
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


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