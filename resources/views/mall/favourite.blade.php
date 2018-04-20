@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container" id="favourite">
            <div class="row1">
                <div class="top-border"></div>
                <div class="top">
                    <span>我的收藏夹</span>
                </div>
                <div class="caret"></div>
                <div class="content">
                    <div class="rows border-index-content">
                        @foreach($favourites as $k=>$favourite)
                        @if(Agent::isMobile())
                        <div class="col-xs-6 border-index">
                            <a href="{{url('/mall/item/'.$favourite->item->id)}}">
                                <img src="{{$favourite->item->thumb}}" class="img-responsive" />
                            </a>
                            <div style="height:40px;">
                                <h4 style="font-size:12px">{{$favourite->item->name}}</h4>
                            </div>
                            <span>{{$favourite->item->point}}风迷币</span>
                            <div class="mobile-btns center-block btns-favourite">
                                <button class="btn btn-view btn-favourite" style="display:block;width:100%;" data-url="{{url('/mall/favourite/'.$favourite->item->id)}}">取消收藏</button>
                                
                            </div>
                        </div>
                        @else
                        <div class="col-md-2 {{ ( $k%6 != 5 and $k != count($favourites)-1 ) ?'border':''}}" style="height:287px;margin-bottom:20px;">
                            <a href="{{url('/mall/item/'.$favourite->item->id)}}"><img src="{{$favourite->item->thumb}}" width="160" height="177" /></a>
                            <div style="height:40px;"><h4>{{$favourite->item->name}}</h4></div>
                            <span>{{$favourite->item->point}}风迷币</span>
                            <div class="center-block text-center">
                            <button class="btn btn-default btn-favourite" data-url="{{url('/mall/favourite/'.$favourite->item->id)}}"><i class="glyphicon glyphicon-star" aria-hidden="true"></i> 取消收藏</button>
                            </div>
                                
                        </div>
                        @endif
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div style="height:200px;width:100%;"></div>
        </div>
    @include('mall.mobile.car_bar',['active'=>'mall'])
    </div>
@endsection
@section('scripts')
    <script>
        $().ready(function () {
            $('.btn-favourite').on('click', function () {
            var url = $(this).attr('data-url');
            var div = $(this).parent('div').parent('div');
            $.post(url, {
                _token: window.Laravel.csrfToken
            }, function (json) {
                if (json.ret == 1100) {
                    $('#modal-login').modal('show');
                } else if (json.ret == 0) {
                    //$('.btn-star').removeClass('btn-star-gray')

                } else {
                    div.remove();
                    //$('.btn-star').addClass('btn-star-gray')
                }
            }, "JSON").fail(function () {
                $('#modal-tip').find('.modal-body').html(
                    '<div class="text-center"><h4>抱歉</h4>服务器发生错误，请重试。</div>');
                $('#modal-tip').find('.modal-title').html(
                    '<img src="/images/mall/mobile/icon-warning.png" height="40" />');
                $('#modal-tip').modal('show');
            })
        })
        })
    </script>
@endsection
