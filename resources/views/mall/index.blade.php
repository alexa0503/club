@extends('layouts.mall') @section('content')
<div id="main">
    <div class="container">
        <div class="row">
            @if(count($kvs)>0)
            <div id="kv">
                <a href="{{$kvs[0]->link}}">
                    <img src="{{$kvs[0]->image}}" width="1090" />
                </a>
                <div id="kv-text">
                    <h2>{{$kvs[0]->title}}</h2>
                    <p>{{$kvs[0]->description}}</p>
                </div>
            </div>
            @endif

            @include('mall.search_bar')
            @if( count($latest) > 0 )
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>最新礼品</span>
                </div>
                <div class="caret"></div>
                <div style="position:absolute;top:0;right:0;margin-right:20px;margin-top:10px;">
                    <a href="/mall/search?keywords=&point_min=&point_max=&cat_id=&order_name=created_at&order_type=DESC" style="color:red;font-weight:bold;">More&gt;&gt;</a>
                </div>
                <div class="content" style="height: 300px;">
                    <div class="rows">
                        @foreach($latest as $k=>$item)
                        <div class="col-md-2 {{ ( $k%6 != 5) ?'border':''}}" style="height:257px;margin-bottom:20px;">
                            <a href="{{url('/mall/item/'.$item->id)}}">
                                <img src="{{$item->thumb}}" width="162" height="177" />
                            </a>
                            <div style="height:40px;">
                                <h4>{{$item->name}}</h4>
                            </div>
                            <span>{{$item->point}}风迷币</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if( count($features2) > 0 )
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>我能兑换</span>
                </div>
                <div class="caret"></div>
                <div style="position:absolute;top:0;right:0;margin-right:20px;margin-top:10px;">
                </div>
                <div class="content" style="height: 300px;">
                    <div class="rows">
                        @foreach($features2 as $k=>$item)
                        <div class="col-md-2 {{ ( $k%6 != 5) ?'border':''}}" style="height:257px;margin-bottom:20px;">
                            <a href="{{url('/mall/item/'.$item->id)}}">
                                <img src="{{$item->thumb}}" width="162" height="177" />
                            </a>
                            <div style="height:40px;">
                                <h4>{{$item->name}}</h4>
                            </div>
                            <span>{{$item->point}}风迷币</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
             @if( count($features3) > 0 )
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>热门兑换</span>
                </div>
                <div class="caret"></div>
                <div style="position:absolute;top:0;right:0;margin-right:20px;margin-top:10px;">
                </div>
                <div class="content" style="height: 300px;">
                    <div class="rows">
                        @foreach($features3 as $k=>$item)
                        <div class="col-md-2 {{ ( $k%6 != 5) ?'border':''}}" style="height:257px;margin-bottom:20px;">
                            <a href="{{url('/mall/item/'.$item->id)}}">
                                <img src="{{$item->thumb}}" width="162" height="177" />
                            </a>
                            <div style="height:40px;">
                                <h4>{{$item->name}}</h4>
                            </div>
                            <span>{{$item->point}}风迷币</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if( count($features1) > 0 )
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>爆款推荐</span>
                </div>
                <div class="caret"></div>
                <div style="position:absolute;top:0;right:0;margin-right:20px;margin-top:10px;">
                    <a href="{{url('mall/category')}}" style="color:red;font-weight:bold;">More&gt;&gt;</a>
                </div>
                <div class="content" style="height: 300px;">
                    <div class="rows">
                        @foreach($features1 as $k=>$item)
                        <div class="col-md-2 {{ ( $k%6 != 5) ?'border':''}}" style="height:257px;margin-bottom:20px;">
                            <a href="{{url('/mall/item/'.$item->id)}}">
                                <img src="{{$item->thumb}}" width="162" height="177" />
                            </a>
                            <div style="height:40px;">
                                <h4>{{$item->name}}</h4>
                            </div>
                            <span>{{$item->point}}风迷币</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif @foreach ($categories as $category) @if( count($category->indexItems) > 0 )
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>{{$category->name}}</span>
                </div>
                <div class="caret"></div>
                <div style="position:absolute;top:0;right:0;margin-right:20px;margion-top:10px;">
                    <a href="{{url('mall/category/'.$category->id)}}" style="color:red;font-weight:bold;">More&gt;&gt;</a>
                </div>
                <div class="content" style="height: 300px;">
                    <div class="rows">
                        @foreach($category->indexItems as $k=>$item)
                        <div class="col-md-2 {{ ( $k%6 != 5 and $k != count($category->indexItems)-1 ) ?'border':''}}" style="height:257px;margin-bottom:20px;">
                            <a href="{{url('/mall/item/'.$item->id)}}">
                                <img src="{{$item->thumb}}" width="162" height="177" />
                            </a>
                            <div style="height:40px;">
                                <h4>{{$item->name}}</h4>
                            </div>
                            <span>{{$item->point}}风迷币</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif @endforeach
            
        </div>
    </div>
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