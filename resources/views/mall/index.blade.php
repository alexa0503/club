@extends('layouts.mall')
@section('content')
<div id="main">
    <div class="container">
        <div class="row">
            @if(count($kvs)>0)
            <div id="kv">
                <a href="{{$kvs[0]->link}}"><img src="{{$kvs[0]->image}}"/></a>
                <div id="kv-text">
                    <h2>{{$kvs[0]->title}}</h2>
                    <p>{{$kvs[0]->description}}</p>
                </div>
            </div>
            @endif
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>爆款推荐</span>
                </div>
                <div class="caret"></div>
                <div class="content" style="min-height: 300px;">
                    <div class="pull-right" style="width: 800px;">
                        <div class="rows">
                            @foreach($features1 as $k=>$item)
                            <div class="col-md-3 {{($k+1<count($features1))?'border':''}}">
                                <div style="height:40px;"><h4>{{$item->name}}</h4></div>
                                <span>{{$item->point}}风迷币</span>
                                <a href="{{url('/mall/item/'.$item->id)}}"><img src="{{$item->thumb}}" width="162" height="177" /></a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @if(count($feature1_kvs)>0)
                    <div class="kv">
                        <div class="slick" style="width: 214px;height:260px;">
                            @foreach($feature1_kvs as $kv)
                            <div><a href="{{$kv->link}}"><img height="260" width="214" src="{{asset($kv->image)}}" alt="{{$kv->title}}" /></a></div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>车载必备</span>
                </div>
                <div class="caret"></div>
                <div class="content" style="min-height: 300px;">
                    <div class="pull-right" style="width: 800px;">
                        <div class="rows">
                            @foreach($features2 as $k=>$item)
                                <div class="col-md-3 {{($k+1<count($features2))?'border':''}}">
                                    <h4>{{$item->name}}</h4>
                                    <span>{{$item->point}}风迷币</span>
                                    <a href="{{url('/mall/item/'.$item->id)}}"><img src="{{$item->thumb}}" width="162" height="177" /></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @if(count($feature2_kvs)>0)
                    <div class="kv">
                        <div class="slick" style="width: 214px;height:260px;">
                            @foreach($feature2_kvs as $kv)
                            <div><a href="{{$kv->link}}"><img height="260" width="214" src="{{asset($kv->image)}}" alt="{{$kv->title}}" /></a></div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
            $('.row1').each(function(){
                var h = $(this).find('.pull-right').height();
                $(this).find('.content').height(h);
            });

            $('.slick').slick({
                'prevArrow':null,
                'nextArrow':null,
                'dots':true,
                'autoplay':true
            });
        })
    </script>
@endsection
