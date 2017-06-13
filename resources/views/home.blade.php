<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Muslim Mate</title>
    <meta name="keywords"
          content="islamic events , prayer time , azkar , weather status , Places , Calendar ,
المناسبات الإسلامية , مواقيت الصلاة , الإذكار , حالة الطقس , التقويم الميلادي , التقويم الهجري">



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
    <link rel="stylesheet" href="{{asset('dist/css/uthman.css')}}">
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
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBxD7m7Qqn0jrQuZNpIZxC37uqK2iPeeRU&language={{$lang}}"></script>
        @if($dir == 'rtl')
        <link rel="stylesheet" href="{{asset('dist/css/rtl-css.css')}}">
    @endif
    @include('analyticstracking')
    <link rel="shortcut icon" href="{{asset('dist/img/muslim-mate.png')}}"/>

</head>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" dir="{{$dir}}">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->

        <a href="#" class="sidebar-toggle sidebar-collapse back-logo" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" dir="ltr">
            <!-- Sidebar toggle button-->
            <a href="{{url('/')}}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>Muslim Mate</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Muslim Mate</b></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="https://play.google.com/store/apps/details?id=com.fekracomputers.muslimmate" class="link-android">
                            <img src="{{asset('dist/img/google_badge.png')}}" alt="" class="img-android">
                        </a>
                    </li>
                    <li class="text-center lang-xs">
                        @if($lang == 'eng')
                        <a href="{{url('/ar')}}" class="text-center margin-top">عربي
                            <img src="{{url('dist/img/language.png')}}" alt="" class="img-responsive img-lang">
                        </a>
                            @else
                            <a href="{{url('/eng')}}" class="text-center margin-top">English
                                <img src="{{url('dist/img/language.png')}}" alt="" class="img-responsive img-lang">
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li>
                    <a href="{{asset('/')}}"> <i class="fa fa-dashboard"></i></a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="row">
                <div class="col-md-3">
                    <div class="small-box bg-prayer">
                        <div class="inner">
                            <h3>{{$nextName}}</h3>

                            <h3 class="font-hour">{{$nextPrayer[0][0]}} :  {{$nextPrayer[0][1]}}</h3>

                        </div>
                        <div class="icon event-ts">
                            <img src="{{asset('dist/img/prayer-b.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-event">
                        <div class="inner">
                            <h3>{{$nextEvent['name']}}</h3>

                            <h4 class="">{{$nextEvent['hday']}} {{$nextEvent['hmonth']}} {{$nextEvent['hyear']}}</h4>
                            <h4 class="">{{$nextEvent['gday']}} {{$nextEvent['gmonth']}} {{$nextEvent['gyear']}}</h4>
                        </div>
                        <div class="icon event-ts">
                            <img src="{{asset('dist/img/'.getImgEvent($nextEvent['name'],$lang).'.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-place">
                        <div class="inner">
                            <h3>{{$today}}</h3>
                            <h4 class="MiladyDate"></h4>
                            <h4 class="HijriDate"></h4>
                        </div>
                        <div class="icon">
                            <img src="{{asset('dist/img/mosque.png')}}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="small-box bg-cloud">
                        <div class="inner">
                            <h3><span class="degree-up">32</span> <span><i class="fa fa-circle-o degree" aria-hidden="true"></i></span></h3>
                            <h4 class="part-margin status-up">Partly Cloudy</h4>
                        </div>
                        <div class="icon">
                            <img src="{{asset('dist/img/cloud.png')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="clearfix"></div>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">

                    @include('frame.prayer')
                    {{--Box Map--}}
                    @include('frame.map')
                    {{--end box map--}}
                    @include('frame.calendar')


                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">
                    @include('frame.weather')
                    @include('frame.events')
                    @include('frame.azkar')
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <h4 class="text-center">تصميم وتطوير فكرة كمبيوتر</h4>
    </footer>


</div>
<!-- ./wrapper -->






{{--Calendar script--}}
<script type="text/javascript">
    var GerDate = new Date();
    var Hijridates = new HijriDate();
    var lang = "{{$lang}}" ;
    console.log(Hijridates.getMonthName());
    $('.HijriDate').text(Hijridates.getDate()+'  '+ getMonthHijri(Hijridates.getMonthName() , lang) + ' ' +Hijridates.getFullYear());
    $('.MiladyDate').text(GerDate.getDate()+'  '+getMonthMilady(GerDate.getMonthName(),lang) + ' ' +GerDate.getFullYear());
    $('.text-date-info').text(GerDate.getDateString());
    function getMonthHijri($name,$lang){
        if($lang == 'ar'){
            switch($name){
                case 'Muhrram':
                    return 'محرم';
                    break;
                case 'Safar':
                    return 'صفر';
                    break;
                case 'Raby Al-Awal':
                    return 'ربيع الأول';
                    break;
                case 'Raby Al-Thaany':
                    return 'ربيع الثاني';
                    break;
                case 'Jumaada Al-Awal':
                    return 'جماد الأول';
                    break;
                case 'Jumaada Al-Thaany':
                    return 'جماد الثاني';
                    break;
                case 'Rajab':
                    return 'رجب';
                    break;
                case 'Sha`bban':
                    return 'شعبان';
                    break;
                case 'Ramadan':
                    return 'رمضان';
                    break;
                case 'Shawwal':
                    return 'شوال';
                    break;
                case 'Thul Qa`dah':
                    return 'ذو القعدة';
                    break;
                case 'Thul Hijjah':
                    return 'ذو الحجة';
                    break;
            }
        }else{
            return $name ;
        }
    }
    function getMonthMilady($name ,$lang){
        if($lang == 'ar'){
            switch($name){
                case 'January':
                    return 'يناير';
                    break;
                case 'February':
                    return 'فبراير';
                    break;
                case 'March':
                    return 'مارس';
                    break;
                case 'April':
                    return 'ابريل';
                    break;
                case 'May':
                    return 'مايو';
                    break;
                case 'June':
                    return 'يونيه';
                    break;
                case 'July':
                    return 'يوليو';
                    break;
                case 'August':
                    return 'اغسطس';
                    break;
                case 'September':
                    return 'سبتمبر';
                    break;
                case 'October':
                    return 'أكتوبر';
                    break;
                case 'November':
                    return 'نوفمبر';
                    break;
                case 'December':
                    return 'ديسمبر';
                    break;
            }
        }
        else{
            return $name ;
        }
    }

    $.widget.bridge('uibutton', $.ui.button);
    if(screen.width < 768){
        $('.sidebar-toggle').remove()
    }

</script>

<script src="{{asset('dist/js/unslider-min.js')}}"></script>
<script src="{{asset('dist/css/jquery-ui.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('dist/js/app.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>

</body>
</html>
