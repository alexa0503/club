<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script language="javascript" id="temp">
		document.write('<meta name="viewport" content="width=640, initial-scale=' + window.screen.width / 640 +
			',user-scalable=no, target-densitydpi=device-dpi">');
	</script>
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
<main id="background"></main>
<div id="mobile">
    <div class="container">
        <div class="header rows">
            <div class="logo"><div class="pull-right" ><img src="/images/mall/mobile/logo_2.png" width="120" style="margin-top:20px;" /></div><img src="/images/mall/mobile/logo_1.png" width="100" /> </div>
        </div>
    </div>
</div>
<script>
$().ready(function(){
    var background = new Image();
    background.src = '/images/mall/mobile/kv.jpg';
    background.onload = function () {
        var loadbackground = document.getElementById('background');
        loadbackground.style.backgroundImage = 'url(' + background.src + ')';
        window.setTimeout(function(){
            window.location.href="/mall"
        },2000)
    }

})
</script>
</body>
</html>
