<div class="box box-primary box-calendar">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-toggle="modal" data-target="#calendarShare"  title="Share Iframe" style="margin-right: 5px;">
                <i class="fa fa-share" aria-hidden="true"></i></button>
            <div class="modal fade calendarShare modal-primary" id="calendarShare" tabindex="-1" role="dialog" aria-labelledby="calendarShare">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Share Iframe
                        </div>
                        <div class="modal-body">

                            <input type="text" class="form-control" value="<iframe src='{{url('/'.$lang.'/calendar')}}' frameborder='0' width='100%'></iframe>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" class="btn btn-transparent btn-sm pull-right reset-calendar" data-toggle="tooltip" title="Reset Calendar" style="margin-right: 5px;">
                <i class="fa fa-history" aria-hidden="true"></i>
            </button>

        </div>

        <span><img src="{{asset('dist/img/calendar.png')}}" alt="" class="margin-img-right"></span>

        <h3 class="box-title">{{$title['calendar']}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body remove-padding">

        <div id="calendar"></div>

    </div>
    <div class="box-footer">
        <h4 class="bold-font"><span class="selected-title"> Selected Date : </span>
            <span class="text-date date-ger">  </span>
            -
            <span class="text-date date-hijri"> </span>
            <span id="picked-text"></span>
        </h4>
    </div>
    <!-- /.box-body -->
</div>
<script type="text/javascript">
    var cal = new Calendar();
    document.getElementById('calendar').appendChild(cal.getElement());
        var pickedTxt = document.getElementById('picked-text');
        cal.callback = function() {
            if(!cal.isHijriMode()){
                var dates = new HijriDate(this.getTime());
                $('.date-ger').text(cal.getDate().getDateString());
                $('.date-hijri').text(dates.getDateString());

            }else{
                var dates = new Date(this.getTime());
                $('.date-ger').text(dates.getDateString());
                $('.date-hijri').text(cal.getDate().getDateString());
            }

        };

    $('.reset-calendar').click(function(){
        cal.destroy();
        cal = new Calendar();
        document.getElementById('calendar').appendChild(cal.getElement());
        var pickedTxt = document.getElementById('picked-text');
        cal.callback = function() {
            if(!cal.isHijriMode()){
                var dates = new HijriDate(this.getTime());
                $('.date-ger').text(cal.getDate().getDateString());
                $('.date-hijri').text(dates.getDateString());

            }else{
                var dates = new Date(this.getTime());
                $('.date-ger').text(dates.getDateString());
                $('.date-hijri').text(cal.getDate().getDateString());
            }

        };

    });
    var GerDate = new Date();
    var Hijridates = new HijriDate();
    $('.date-hijri').text(Hijridates.getDateString());
    $('.date-ger').text(GerDate.getDateString());
    $('.HijriDate').text(Hijridates.getDateString());
    $('.MiladyDate').text(GerDate.getDateString());
    $('.text-date-info').text(GerDate.getDateString());


</script>
