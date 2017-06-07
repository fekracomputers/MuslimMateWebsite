<div class="box box-primary box-weather">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-toggle="modal" data-target="#weatherShare"  title="Share Iframe" style="margin-right: 5px;">
                <i class="fa fa-share" aria-hidden="true"></i></button>
            <div class="modal fade weatherShare modal-primary" id="weatherShare" tabindex="-1" role="dialog" aria-labelledby="weatherShare">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Share Iframe
                        </div>
                        <div class="modal-body">

                            <input type="text" class="form-control" value="<iframe src='{{url('/'.$lang.'/weather')}}' frameborder='0' width='100%'></iframe>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <span class="margin-img-right"><img src="{{asset('dist/img/weather.png')}}" alt=""></span>
        <h3 class="box-title">{{$title['weather']}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body remove-padding">
        <div class="padding-weather">
            <div class="col-md-7 col-sm-7 col-xs-7 border-right-d">

                <h4 class="text-primary">
                    <span class="img-address"> <img src="{{asset('dist/img/location.png')}}" alt="location img" class="margin-img-right"></span>
                    <span class="country">{{$city}} ,{{$country}}</span>
                </h4>
                <h4 class="bold-font DayNow">Tuesday 11:00 AM</h4>
                <h4 class="bold-font desc-weather">Partly Cloudy</h4>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
                <h4 class="bold-font">
                    <span><img src="{{asset('dist/img/temprature.png')}}" alt="temprature" class="margin-img-right"></span>
                    <span class="temp">36</span> <i class="fa fa-circle-o degree" aria-hidden="true"></i></h4>
                <h4 class="bold-font">
                    <span><img src="{{asset('dist/img/drops.png')}}" alt="drops" class="margin-img-right"></span>
                    <span class="rain"> 24% </span>
                </h4>
                <h4 class="bold-font">
                    <img src="{{asset('dist/img/wind.png')}}" class="margin-img-right" alt="">
                    <span class="wind"> 3.66 m/s</span>
                </h4>

            </div>
        </div>
        <div class="pattern">
            <div class="col-md-3 col-xs-3 col-sm-3 text-center back-weather-1">
                <h3 class="time0">12:00</h3>
                <h2><span class="degree0">24</span> <i class="fa fa-circle-o degree" aria-hidden="true"></i></h2>
            </div>
            <div class="col-md-3 col-xs-3 col-sm-3 text-center back-weather-2">
                <h3 class="time1">15:00</h3>
                <h2><span class="degree1">31</span> <i class="fa fa-circle-o degree" aria-hidden="true"></i></h2>
            </div>
            <div class="col-md-3 col-xs-3 col-sm-3 text-center back-weather-3">
                <h3 class="time2">18:00</h3>
                <h2><span class="degree2">30</span> <i class="fa fa-circle-o degree" aria-hidden="true"></i></h2>
            </div>
            <div class="col-md-3 col-xs-3 col-sm-3 text-center back-weather-4">
                <h3 class="time3">21:00</h3>
                <h2 ><span class="degree3">24</span> <i class="fa fa-circle-o degree" aria-hidden="true"></i></h2>
            </div>
        </div>

    </div>

    <!-- /.box-body -->
</div>
<script>
    $(document).ready(function () {
        var dateNow = new Date();
        var DayLi = dateNow.getDayName()  ;
        var hour = dateNow.getHours() ;
        var minute = dateNow.getMinutes() ;
        $('.DayNow').text(DayLi + ' ' + hour +':'+minute);


                var long = parseFloat({{$long}}) ;
                var lat = parseFloat({{$lat}}) ;
                var APIText = 'http://api.openweathermap.org/data/2.5/forecast?lat='+lat+'&lon='+long+'&appid=ac6f2688dbfdc24772be777529947e27';
                var APIToday = 'http://api.openweathermap.org/data/2.5/weather?lat='+lat+'&lon='+long+'&appid=ac6f2688dbfdc24772be777529947e27';
                //change city variable dynamically as required
                $.getJSON(APIText).success(function(data){
                    $.getJSON(APIToday).success(function(res){

                        var temp  = (res.main.temp -272.15);
                        $('.temp').html( Math.round(temp)  );
                        $('.degree-up').html( Math.round(temp)  );
                        $('.wind').html( res.wind.speed + ' m/s' );
                        $('.desc-weather').html( res.weather[0].description );
                        $('.status-up').html( res.weather[0].description );
                        $('.rain').html( res.main.humidity + ' % ' );
                    });

                    var temp0 = (data.list[0].main.temp -272.15);
                    $('.degree0').html(  Math.round(temp0) );

                    var temp1 = (data.list[1].main.temp -272.15);
                    $('.degree1').html(  Math.round(temp1) );

                    var temp2 = (data.list[2].main.temp -272.15);
                    $('.degree2').html(  Math.round(temp2) );

                    var temp3 = (data.list[3].main.temp -272.15);
                    $('.degree3').html(  Math.round(temp3) );

                });

    });
</script>