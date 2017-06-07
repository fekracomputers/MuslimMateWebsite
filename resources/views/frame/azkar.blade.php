<div class="box box-primary box-zekr">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-toggle="modal" data-target="#zkerShare"  title="Share Iframe" style="margin-right: 5px;">
                <i class="fa fa-share" aria-hidden="true"></i></button>
            <div class="modal fade zkerShare modal-primary" id="zkerShare" tabindex="-1" role="dialog" aria-labelledby="zkerShare">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Share Iframe
                        </div>
                        <div class="modal-body">

                            <input type="text" class="form-control" value="<iframe src='{{url('/'.$lang.'/azkar')}}' frameborder='0' width='100%'></iframe>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <span><img src="{{asset('dist/img/allah.png')}}" alt="allah" class="margin-img-right"></span>

        <h3 class="box-title">{{$title['azkar']}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body" dir="ltr">
        <select class="zekr" id="zekr">
            @foreach($azkar as $row)
                @if($row->ZekrTypeID == 7)
                    <option value="{{$row->ZekrTypeID}}" selected>{{$row->ZekrTypeName}}</option>
                @else
                    <option value="{{$row->ZekrTypeID}}">{{$row->ZekrTypeName}}</option>
                @endif
            @endforeach
        </select>
        <input type="hidden" class="hidden-zekr" value="{{$azkar[5]->ZekrTypeID}}">

        <div class="zekr-content">

        </div>

    </div>
    <!-- /.box-body -->
</div>

<script>
    $(document).ready(function() {
        $(".zekr").select2({
            dir: "rtl"
        });

        $('.zekr').on("select2:select select2:unselect", function (e) {
            var id = $(this).val();
            initZekr(id);

        });
        var id = $('.hidden-zekr').val();

        function initZekr(id) {
            var UrlPath = "/getAzkar/" + id;
            $.getJSON(UrlPath, function (res) {
                        var data = res;
                        var content = "";
                        for (var i = 0; i < data.length; i++) {
                            var str2 = "<li>" + data[i]['ZekrContent'] + "" +
                                    "<h4 class='text-left text-primary margin-bg-top bold-font'><span class='text-repeat'></span>" +
                                    "<span>التكرار : " + data[i]['ZekrNoOfRep'] + " مرة</span>" +
                                    '<span><img src="/dist/img/repeat.png" alt="repeat" class="img-repeat"></span></h4>' +
                                    "</li>";
                            content = content.concat(str2);
                        }
                        $('.zekr-content').html('<div class="my-slider' + id + '">' +
                                '<ul>' + content + '</ul></div>');
                        $(".my-slider" + id).unslider();
                        $("<hr class='footer-class'>").insertBefore(".next");
                        $('.next').html('<span class="glyphicon glyphicon-chevron-left"></span>')
                        $('.prev').html('<span class="glyphicon glyphicon-chevron-right"></span>')
                    }
            );
        }

        initZekr(id);
    });
</script>