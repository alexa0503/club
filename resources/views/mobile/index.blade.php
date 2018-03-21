<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- ionicons -->
    <link rel="icon" type="image/png" href="/favicon.png">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="/css/font-awesome.4.6.0.css">
    <link rel="stylesheet" type="text/css" href="/css/mobile.css">
    <script src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        $().ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window.Laravel
                }
            });
        })
    </script>
</head>
<body>
<div id="mobile">
    <div class="container">
        <div class="header row">
            <div class="logo"><div class="pull-right" ><img src="/images/mall/mobile/logo_2.png" style="max-height:32px;"  class="img-responsive" /></div><img src="/images/mall/mobile/logo_1.png" style="max-height:32px;margin-top:18px;" class="img-responsive"  /> </div>
        </div>
    </div>
    <div class="container fixed-bottom">
        <div class="footer text-center">
            <a href="{{ url('mall') }}" class="btn btn-footer">立即加入</a>
        </div>
    </div>
</div>
</body>
</html>
