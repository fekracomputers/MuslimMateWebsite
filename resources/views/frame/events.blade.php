<div class="box box-primary box-events">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-toggle="modal" data-target="#eventsShare"  title="Share Iframe" style="margin-right: 5px;">
                <i class="fa fa-share" aria-hidden="true"></i></button>
            <div class="modal fade eventsShare modal-primary" id="eventsShare" tabindex="-1" role="dialog" aria-labelledby="eventsShare">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Share Iframe
                        </div>
                        <div class="modal-body">

                            <input type="text" class="form-control" value="<iframe src='{{url('/'.$lang.'/events')}}' frameborder='0' width='100%'></iframe>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

                            <span>
                                <img src="{{asset('dist/img/islamic-events.png')}}" alt="Events" class="margin-img-right">
                            </span>
        <h3 class="box-title">{{$title['events']}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body remove-padding" dir="{{$dir}}">
        <?php $style = 1;?>
        @foreach($events as $row)
            <div class="col-md-6 col-sm-6 remove-padding">
                <?php if($row['name'] == $nextEvent['name']){$event = 'event-active'; }else{$event = '';} ?>

                <div class="padding-all {{$event}}  style-{{$style}}">
                    <h3 class="margin-top-mini">
                                                <span>
                                                    <img src="{{asset('dist/img/'.getImgEvent($row['name'],$lang).'.png')}}" alt="icon" class="margin-img-right">
                                                </span>
                        {{$row['name']}}
                    </h3>
                    <p class="text-g1">{{$row['hday'] .' ' .$row['hmonth'] .' '.$row['hyear']}}</p>
                    <p class="text-g1">{{$row['gday'] .' ' .$row['gmonth'] .' '.$row['gyear']}}</p>

                </div>
            </div>
            <?php $style++?>
            @if($style % 2)
                <div class="clearfix"></div>
            @endif
        @endforeach
    </div>
    <!-- /.box-body -->
</div>
