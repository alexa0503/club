@extends('layouts.mall')
@section('content')
<div id="main">
    <div class="container">
        <div class="row">
            <div id="kv">
                <img src="/images/mall/kv.jpg"/>
                <div id="kv-text">
                    <h2>颜值动人 驾值动心</h2>
                    <p>超级都市suv风光580</p>
                </div>
            </div>
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>爆款推荐</span>
                </div>
                <div class="caret"></div>
                <div class="content">
                    <div class="pull-right" style="width: 800px;">
                        <div class="rows">
                            @foreach($features1 as $k=>$item)
                            <div class="col-md-3 {{($k+1<count($features1))?'border':''}}">
                                <h4>{{$item->name}}</h4>
                                <span>{{$item->point}}积分</span>
                                <a href="{{url('/mall/item/'.$item->id)}}"><img src="{{$item->thumb}}" width="162" height="177" /></a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="kv">
                        <div class="slick" style="width: 190px;">
                            <div><img src="/images/mall/row1-kv.jpg" /></div>
                            <div><img src="/images/mall/row1-kv.jpg" /></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>车载必备</span>
                </div>
                <div class="caret"></div>
                <div class="content">
                    <div class="pull-right" style="width: 800px;">
                        <div class="rows">
                            @foreach($features2 as $k=>$item)
                                <div class="col-md-3 {{($k+1<count($features2))?'border':''}}">
                                    <h4>{{$item->name}}</h4>
                                    <span>{{$item->point}}积分</span>
                                    <a href="{{url('/mall/item/'.$item->id)}}"><img src="{{$item->thumb}}" width="162" height="177" /></a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="kv">
                        <div class="slick" style="width: 190px;">
                            <div><img src="/images/mall/row1-kv.jpg" /></div>
                            <div><img src="/images/mall/row1-kv.jpg" /></div>
                        </div>
                    </div>
                </div>
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