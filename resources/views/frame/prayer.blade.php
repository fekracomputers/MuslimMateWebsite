<div class="box box-primary box-prayer">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-toggle="modal" data-target="#prayerShare"  title="Share Iframe" style="margin-right: 5px;">
                <i class="fa fa-share" aria-hidden="true"></i></button>
            <div class="modal fade prayerShare modal-primary" id="prayerShare" tabindex="-1" role="dialog" aria-labelledby="prayerShare">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Share Iframe
                        </div>
                        <div class="modal-body">

                            <input type="text" class="form-control" value="<iframe src='{{url('/'.$lang.'/prayer')}}' frameborder='0' width='100%'></iframe>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-transparent btn-sm pull-right" id="calender-icon" style="margin-right: 5px;">
                <i class="fa fa-calendar"></i></button>
        </div>

        <i class="ion ion-clipboard"></i>

        <h3 class="box-title">{{$title['prayer']}}</h3>
        <input type="text" id="datepicker" style="display: none" class="pull-right">
    </div>
    <!-- /.box-header -->
    <div class="box-body remove-padding">
        <div class="header-prayer">
            <div class="row">
                <div class="col-md-9 col-sm-9 col-xs-8 text-left">
                    <h3 class="text-place">{{$city}} , {{$country}}</h3>
                    <h4 class="text-date-info"></h4>
                </div>
                <div class="col-md-3 col-xs-4 text-right">
                    <img src="{{asset('dist/img/pray-time.png')}}" alt="Prayer Time" class="margin-mins-bttom">
                </div>
            </div>
        </div>
        <hr class="gray-color">
        <div class="row">
            <div class="col-md-6 text-center">

                <h3 class="next-prayer">{{$nextName}}</h3>
                <h3 class="next-prayer">{{$nextPrayer[0][0]}} :  {{$nextPrayer[0][1]}}</h3>
                <hr>
                <h4 class="left-time">Left</h4>
                <div id="clock" class="left-time"></div>
            </div>
            <div class="col-md-6">
                <div class="prayerTime">
                    <div class="pattern-pray">
                        <div class="col-md-4 pull-right">
                            <h4 class="bold-font">{{$prayer[0][0]}} : {{$prayer[0][1]}}</h4>
                        </div><div class="col-md-8">
                            <h4 class="text-left bold-font">{{$prayerName[0]}}</h4></div></div>
                    <div class="pattern-pray">
                        <div class="col-md-4 pull-right">
                            <h4 class="bold-font">{{$prayer[1][0]}} : {{$prayer[1][1]}}</h4>
                        </div><div class="col-md-8">
                            <h4 class="text-left bold-font">{{$prayerName[1]}}</h4></div></div>
                    <div class="pattern-pray">
                        <div class="col-md-4 pull-right">
                            <h4 class="bold-font">{{$prayer[2][0]}} : {{$prayer[2][1]}}</h4>
                        </div><div class="col-md-8">
                            <h4 class="text-left bold-font">{{$prayerName[2]}}</h4></div></div>
                    <div class="pattern-pray">
                        <div class="col-md-4 pull-right">
                            <h4 class="bold-font">{{$prayer[3][0]}} : {{$prayer[3][1]}}</h4>
                        </div><div class="col-md-8">
                            <h4 class="text-left bold-font">{{$prayerName[3]}}</h4></div></div>
                    <div class="pattern-pray">
                        <div class="col-md-4 pull-right">
                            <h4 class="bold-font">{{$prayer[4][0]}} : {{$prayer[4][1]}}</h4>
                        </div><div class="col-md-8">
                            <h4 class="text-left bold-font">{{$prayerName[4]}}</h4></div></div>
                    <div class="pattern-pray">
                        <div class="col-md-4 pull-right">
                            <h4 class="bold-font">{{$prayer[5][0]}} : {{$prayer[5][1]}}</h4>
                        </div><div class="col-md-8">
                            <h4 class="text-left bold-font">{{$prayerName[5]}}</h4></div></div>

                </div>

            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<script>
    $( "#datepicker" ).datepicker();
    $('#calender-icon').click(function () {
        $('#datepicker').show().focus().hide();
    });
    $('#datepicker').on('change',function(){
        var DateChange = $(this).val() ;
        var allVal = DateChange.split('/');
        var start =  parseInt(allVal[0])+'-'+ parseInt(allVal[1])+'-'+ parseInt(allVal[2]);

        $.getJSON('/getPrayerTimes/'+parseFloat({{$lat}})+'/'+ parseFloat({{$long}}) +'/'+start ,
                function(res){
                    var data = res['times'] ;
                    var fajer = "{{$prayerName[0]}}" ;
                    var doha = "{{$prayerName[1]}}" ;
                    var zohr = "{{$prayerName[2]}}" ;
                    var asr = "{{$prayerName[3]}}" ;
                    var maghreb = "{{$prayerName[4]}}" ;
                    var esha = "{{$prayerName[5]}}" ;
                    $('.prayerTime').html('' +
                            '<div class="pattern-pray">'+
                            '<div class="col-md-4 pull-right">'+
                            '<h4 class="bold-font">'+data[0][0]+' : '+ data[0][1] +'</h4>'+
                            '</div><div class="col-md-8">'+
                            '<h4 class="text-left bold-font">'+fajer+'</h4></div></div>'+
                            '<div class="pattern-pray">'+
                            '<div class="col-md-4 pull-right">'+
                            '<h4 class="bold-font">'+data[1][0]+' : '+ data[1][1] +'</h4>'+
                            '</div><div class="col-md-8">'+
                            '<h4 class="text-left bold-font">'+doha+'</h4></div></div>'+
                            '<div class="pattern-pray">'+
                            '<div class="col-md-4 pull-right">'+
                            '<h4 class="bold-font">'+data[2][0]+' : '+ data[2][1] +'</h4>'+
                            '</div><div class="col-md-8">'+
                            '<h4 class="text-left bold-font">'+zohr+'</h4></div></div>'+
                            '<div class="pattern-pray">'+
                            '<div class="col-md-4 pull-right">'+
                            '<h4 class="bold-font">'+data[3][0]+' : '+ data[3][1] +'</h4>'+
                            '</div><div class="col-md-8">'+
                            '<h4 class="text-left bold-font">'+asr+'</h4></div></div>'+
                            '<div class="pattern-pray">'+
                            '<div class="col-md-4 pull-right">'+
                            '<h4 class="bold-font">'+data[4][0]+' : '+ data[4][1] +'</h4>'+
                            '</div><div class="col-md-8">'+
                            '<h4 class="text-left bold-font">'+maghreb+'</h4></div></div>'+
                            '<div class="pattern-pray">'+
                            '<div class="col-md-4 pull-right">'+
                            '<h4 class="bold-font">'+data[5][0]+' : '+ data[5][1] +'</h4>'+
                            '</div><div class="col-md-8">'+
                            '<h4 class="text-left bold-font">'+esha+'</h4></div></div>'
                    );
                    var d = new Date(res['year']+"-"+res['month']+"-"+res['day']);
                    $('.text-date-info').text(d.getDateString());


                });
    })
    /*Left Time  Function*/
    $('#clock').countdown("{{$myear}}/{{MiladyMonthNumber($mMonth , $lang)}}/{{$mday}} {{$nextPrayer[0][0]}}:{{$nextPrayer[0][1]}}:00", function(event) {
        var totalHours = event.offset.totalDays * 24 + event.offset.hours;
        $(this).html(event.strftime(totalHours + ' hr %M min %S sec'));
    });

</script>