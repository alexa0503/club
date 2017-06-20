@extends('layouts.mall')
@section('content')
    <div id="main">
        <div class="container">
            <div class="row" id="item-top">
                <div class="pull-right" style="width:640px;" id="item-detail">
                    <div class="title">Mars by crazybaby  磁悬浮 无线蓝牙音箱</div>
                    <div class="subtitle">便携式 HiFi智能音响 深空灰色</div>
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-md-2 col-xs-2 control-label">市场价:</label>
                            <div class="col-lg-10"><label class="help-block" for="" style="color:red;">168923积分</label></div><!-- /.col -->
                        </div><!-- /form-group -->
                        <div class="form-group">
                            <label for="name" class="col-md-2 col-xs-2 control-label">选择:</label>
                            <div class="col-lg-10">
                                <div class="funkyradio">
                                    <div class="funkyradio-default">
                                        <input type="radio" name="radio" id="radio1" />
                                        <label for="radio1">颜色1</label>
                                    </div>
                                    <div class="funkyradio-default">
                                        <input type="radio" name="radio" id="radio2" />
                                        <label for="radio2">颜色2</label>
                                    </div>
                                </div>

                                <label class="help-block" for=""></label>
                            </div><!-- /.col -->
                        </div><!-- /form-group -->
                        <div class="form-group">
                            <label for="name" class="col-md-2 col-xs-2 control-label">数量:</label>
                            <div class="col-lg-10">
                                <div class="input-group" style="width: 100px;">
                                    <span class="input-group-addon" id="basic-addon1">+</span>
                                    <input type="text" value="1" class="form-control" placeholder="" aria-describedby="basic-addon1">
                                    <span class="input-group-addon" id="basic-addon1">-</span>
                                </div>
                                <label class="help-block" for=""></label></div><!-- /.col -->
                        </div><!-- /form-group -->
                        <button type="submit" class="btn btn-lg btn-custom">立即兑换</button>
                    </form>

                </div>
                <div id="images">
                    <div class="slider slider-for">
                        <div><img src="/images/mall/item-1.jpg" width="400" height="400"/></div>
                        <div><img src="/images/mall/item-1.jpg" width="400" height="400"/></div>
                        <div><img src="/images/mall/item-1.jpg" width="400" height="400"/></div>
                        <div><img src="/images/mall/item-1.jpg" width="400" height="400"/></div>
                    </div>
                    <div class="slider slider-nav">
                        <div><img src="/images/mall/item-1.jpg" width="50" height="50"/></div>
                        <div><img src="/images/mall/item-1.jpg" width="50" height="50"/></div>
                        <div><img src="/images/mall/item-1.jpg" width="50" height="50"/></div>
                        <div><img src="/images/mall/item-1.jpg" width="50" height="50"/></div>
                        <div><img src="/images/mall/item-1.jpg" width="50" height="50"/></div>
                    </div>
                </div>
            </div>
            <div class="row" id="item-content">
                <div class="text-center"><img src="/images/mall/item-content.jpg" width="940" height="915" /></div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: false,
            slidesToScroll: 0,
            asNavFor: '.slider-for',
            dots: false,
            centerMode: false,
            focusOnSelect: true
        });
    </script>
@endsection