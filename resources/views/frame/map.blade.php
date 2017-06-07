<div class="box box-primary box-map">
    <div class="box-header">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-transparent btn-sm pull-right" data-toggle="modal" data-target="#mapShare"  title="Share Iframe" style="margin-right: 5px;">
                <i class="fa fa-share" aria-hidden="true"></i></button>
            <div class="modal fade mapShare modal-primary" id="mapShare" tabindex="-1" role="dialog" aria-labelledby="mapShare">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            Share Iframe
                        </div>
                        <div class="modal-body">

                            <input type="text" class="form-control" value="<iframe src='{{url('/'.$lang.'/map')}}' frameborder='0' width='100%'></iframe>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <span><img src="{{asset('dist/img/places.png')}}" alt="places" class="margin-img-right"></span>

        <h3 class="box-title">{{$title['places']}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body remove-padding">
        <div id="map" style="height: 400px;"></div>
    </div>

    <!-- /.box-body -->
</div>

<script>
    $(document).ready(function(){
        var myPlace = {lat: parseFloat({{$lat}}), lng: parseFloat({{$long}}) };
        var map = new google.maps.Map(document.getElementById('map'), {
            center: myPlace,
            zoom: 15
        });
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var service = new google.maps.places.PlacesService(map);
                service.nearbySearch({
                    location : pos,
                    radius : 5500,
                    type : [ 'mo' ]
                }, callback);

                var geocoder = new google.maps.Geocoder;
                geocoder.geocode({'location': pos}, function(results, status) {
                    if (status === 'OK') {
                        if (results[1]) {
                            var PlaceName = results[1].address_components[0].long_name + ' , ' +
                                    results[1].address_components[1].long_name + ' ' ;
                            $('.country').html(PlaceName);

                        }
                    }
                });

                map.setCenter(pos);
                var long = position.coords.longitude ;
                var lat = position.coords.latitude ;
            }, function() {
                handleLocationError(true,  map.getCenter());
            });
        } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, map.getCenter());
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                    'Error: The Geolocation service failed.' :
                    'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
        }
        function callback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);
                }
            }
        }

        function createMarker(place) {
            var placeLoc = place.geometry.location;
            var marker = new google.maps.Marker({
                map : map,
                position : place.geometry.location
            });

        }
    });

</script>