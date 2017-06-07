<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Muslim Mate - Weather</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/unslider.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/unslider-dots.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/calendar-hijri.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/jquery-ui.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.2.3 -->
    <script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <!-- Bootstrap 3.3.6 -->
    <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('dist/js/hijri-date.js')}}"></script>
    <script src="{{asset('dist/js/calendar-hijri-geo.js')}}"></script>
    <script src="{{asset('dist/js/select2.full.js')}}"></script>
    <script src="{{asset('dist/js/jquery.countdown.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBxD7m7Qqn0jrQuZNpIZxC37uqK2iPeeRU"></script>
    <style>
        body{
            background: #ecf0f5;
        }
    </style>
    @if($dir == 'rtl')
        <link rel="stylesheet" href="{{asset('dist/css/rtl-css.css')}}">
    @endif

    @include('analyticstracking')

</head>
<body dir="{{$dir}}">
<!-- Main content -->
<section class="content no-padding">
    @include('frame.weather')
</section>

<script type="text/javascript">
    var GerDate = new Date();
    var Hijridates = new HijriDate();
    $('.HijriDate').text(Hijridates.getDateString());
    $('.MiladyDate').text(GerDate.getDateString());
    $('.text-date-info').text(GerDate.getDateString());

    $.widget.bridge('uibutton', $.ui.button);

</script>

<script src="{{asset('dist/js/unslider-min.js')}}"></script>
<script src="{{asset('dist/css/jquery-ui.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('dist/js/app.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>

</body>
</html>
