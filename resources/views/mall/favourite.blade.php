@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container">
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>我的收藏夹</span>
                </div>
                <div class="caret"></div>
                <div class="content" style="height: 300px;">
                    <div class="rows">
                        @foreach($favourites as $k=>$favourite)
                        @if(Agent::isMobile())
                        <div class="col-xs-6" style="margin-bottom:20px;height:200px;">
                            <a href="{{url('/mall/item/'.$favourite->item->id)}}">
                                <img src="{{$favourite->item->thumb}}" class="img-responsive" />
                            </a>
                            <div style="height:40px;">
                                <h4 style="font-size:12px">{{$favourite->item->name}}</h4>
                            </div>
                            <span>{{$favourite->item->point}}风迷币</span>
                        </div>
                        @else
                        <div class="col-md-2 {{ ( $k%6 != 5 and $k != count($favourites)-1 ) ?'border':''}}" style="height:257px;margin-bottom:20px;">

                            <a href="{{url('/mall/item/'.$favourite->item->id)}}"><img src="{{$favourite->item->thumb}}" width="160" height="177" /></a>
                            <div style="height:40px;"><h4>{{$favourite->item->name}}</h4></div>
                            <span>{{$favourite->item->point}}风迷币</span>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div style="height:77px;width:100%;"></div>
        </div>
    @include('mall.mobile.car_bar',['active'=>'mall'])
    </div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
        })
    </script>
@endsection
