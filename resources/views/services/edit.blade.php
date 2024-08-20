@extends('layouts.app')
@section('content')
<style type="text/css">
   /* 
   * Always set the map height explicitly to define the size of the div element
   * that contains the map. 
   */
   #map {
   height: 50%;
   }
</style>
<script >
   var gallery="{{url('service_images/'.$service->id.'')}}";
   
   var delete_url="{{url('service_image_delete')}}";
</script>
<body>
   <section class="detail-page bg-image--parallax">
      <div class="container">
         <h3 class="mb-5 font-weight-700 text-effect">Edit Service</h3>
         <div class="row gx-lg-5">
            <div class="col-lg-8">
               <form class="generic-form" id="form99" action="{{route('services.update',$service->id)}}" method="POST" class="form-validate">
                                                    @csrf
                                                    @method('PUT')
                  <div class="row gx-5 mb-3">
                     <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                           <label>Title</label>
                           <input type="text" name="title" value="{{$service->title}}" minlength="8"  required class="form-control" />
                            @error('title')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        </div>
                     </div>
                      <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                           <label>Price</label>
                           <input type="number" name="price" value="{{$service->price}}" step="0.01"  max="1000000" class="form-control" />
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                           <label>Email</label>
                           <input type="email" name="email" value="{{$service->email}}" class="form-control" />
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                           <label>Contact Name</label>
                           <input type="text" required  name="contact_name" value="{{$service->contact_name}}" class="form-control" />
                        </div>
                     </div>
                     <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                           <label>Contact Number</label>
                           <input type="tel" required onkeyup="numbersOnly(this)"  maxlength="16" name="contact_number" value="{{$service->contact_number}}" placeholder="+4930901820" class="form-control" />
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="form-group">
                           <label>Description (Maximum 2000 characters)</label>
                           <textarea class="form-control" maxlength="2000" name="description"  id="editor1" rows="10" cols="80">{{$service->description}}</textarea>
                        </div>
                     </div>
                 
                     
                      <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                           <label>Address</label>
                           <div id="pac-container">
                              <input id="pac-input" required class="form-control"   readonly
                           onfocus="this.removeAttribute('readonly');" value="{{$service->address}}" name="address" type="text" placeholder="Enter a location" />
                               @error('address')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                         @error('latitude')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                           </div>
                           <input type="hidden" id="s_latitude" value="{{$service->latitude}}" name="latitude">
                           <input type="hidden" id="s_longitude" value="{{$service->longitude}}" name="longitude">
                        </div>
                     </div>
                      <div class="col-lg-6 col-md-12">
                            <div class="form-group">
                                <label class="">Status</label>
                                 <select class="form-control select-2" name="status">
                                     <option value="Active">Active</option>
                                    <option value="In-Active">In-Active</option>
                                   
                                 </select>
                                  
                            </div>
                        </div>
                
             
                   
                    
                  
                  </div>
                   <div action="{{url('service_image')}}" method="POST"  id="dropzone" class="dropzone" class="form-validate">
                  @csrf
               </div>
                  <div class="mt-5 mb-3 text-end">
                     <a href="{{url('service')}}" class="btn btn-secondary text-white px-5 py-2 font-size-18">Cancel</a>
                  <button class="btn btn-primary px-5 py-2 font-size-18">Save</button>
               </div>
               </form>

              
             
            </div>
            <div class="col-lg-4 mt-757-md">
               <div id="map" class="mt-4"></div>
               <div id="infowindow-content">
                  <img src="" width="16" height="16" id="place-icon" />
                  <span id="place-name" class="title"></span><br />
                  <span id="place-address"></span>
               </div>
            </div>
         </div>
      </div>
   </section>
</body>
@endsection

@section('js')
 <script
         src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXGsx1M8NgD6v08sSROn2Wud8j-XKjK0U&callback=initMap&libraries=places&v=weekly"
         async
         ></script>
     <script type="text/javascript">
         
         "use strict";


         // This example requires the Places library. Include the libraries=places
         // parameter when you first load the API. For example:
         // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
         Object.defineProperty(exports, "__esModule", {
    value: true
});

function initMap() {
  
   var myLatLng = { lat: {{$service->latitude}}, lng: {{$service->longitude}} };
     var map = new google.maps.Map(document.getElementById("map"), {
        center:myLatLng,
        zoom: 17,
    });
    var card = document.getElementById("pac-card");
    var originLatitude = document.getElementById('s_latitude');
    var originLongitude = document.getElementById('s_longitude');
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
    var center = {
        lat: 50.064192,
        lng: -130.605469
    };
    // Create a bounding box with sides ~10km away from the center point
    var defaultBounds = {
        north: center.lat + 0.1,
        south: center.lat - 0.1,
        east: center.lng + 0.1,
        west: center.lng - 0.1,
    };
    var input = document.getElementById("pac-input");
    var options = {
        bounds: defaultBounds,
        componentRestrictions: {
            country: "ES"
        },
        fields: ["address_components", "geometry", "icon", "name"],
        strictBounds: false,

    };
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    // Set initial restriction to the greater list of countries.
    autocomplete.setComponentRestrictions({
        country: ["ES", "pr", "vi", "gu", "mp"],
    });

    var southwest = {
        lat: 5.6108,
        lng: 136.589326
    };
    var northeast = {
        lat: 61.179287,
        lng: 2.64325
    };
    var newBounds = new google.maps.LatLngBounds(southwest, northeast);
    autocomplete.setBounds(newBounds);
    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById("infowindow-content");
    infowindow.setContent(infowindowContent);
     var geocoder = new google.maps.Geocoder();
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
        draggable: true,
        position:myLatLng,
        animation: google.maps.Animation.DROP,

    });
    /*var myLatLng = { lat: -25.363, lng: 131.044 };
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 4,
        center: myLatLng,
    });
    new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: "Hello World!",
    });*/
    
  google.maps.event.addListener(marker, "dragend", function(e) {
            var lat, lng, address;
             
            geocoder.geocode({
                "latLng": marker.getPosition()
            }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    lat = marker.getPosition().lat();
                    lng = marker.getPosition().lng();
                    address = results[0].formatted_address;
                    document.getElementById("s_latitude").value = lat;
                    document.getElementById("s_longitude").value = lng;
                        
                    if (document.getElementById("pac-input") != null) {

                        document.getElementById("pac-input").value = address;
                        infowindowContent.children["place-address"].textContent = address;
        marker.setVisible(true);
        infowindow.open(map, marker);
                    }
                }
            });
        });
    autocomplete.addListener("place_changed", function() {
        infowindow.close();
        marker.setVisible(true);
        var place = autocomplete.getPlace();
        if (place.hasOwnProperty('place_id')) {
            if (!place.geometry) {
                // window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            $('#s_latitude').val(place.geometry.location.lat());
            $('#s_longitude').val(place.geometry.location.lng());
        } else {
            $('#s_latitude').val(place.geometry.location.lat());
            $('#s_longitude').val(place.geometry.location.lng());
        }
        console.log(place.geometry.location);
        if (!place.geometry || !place.geometry.location) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); // Why 17? Because it looks good.
        }
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        var address = "";
        if (place.address_components) {
            address = [
                (place.address_components[0] &&
                    place.address_components[0].short_name) ||
                "",
                (place.address_components[1] &&
                    place.address_components[1].short_name) ||
                "",
                (place.address_components[2] &&
                    place.address_components[2].short_name) ||
                "",
            ].join(" ");
        }
        infowindowContent.children["place-icon"].src = place.icon;
        infowindowContent.children["place-address"].textContent = address;
        infowindow.open(map, marker);
    });
    function placeMarkerAndPanTo(latLng, map) {
      alert(1);
    new google.maps.Marker({
        position: latLng,
        map: map,
    });
    map.panTo(latLng);
}


    // Sets a listener on a given radio button. The radio buttons specify
    // the countries used to restrict the autocomplete search.
    function setupClickListener(id, countries) {
        var radioButton = document.getElementById(id);
        radioButton.addEventListener("click", function() {
            autocomplete.setComponentRestrictions({
                country: countries
            });
        });
    }
    setupClickListener("changecountry-de", "DE");
    setupClickListener("changecountry-de-and-uot", [
        "DE",
        "pr",
        "vi",
        "gu",
        "mp",
    ]);
}

window.initMap = initMap;
         
         function assignCapacity(value){
          $('#capacity-2').val(Math.max(value-1, 0));
          $('#capacity-3').val(Math.max(value-2, 0));
          $('#capacity-4').val(Math.max(value-3, 0));
         }
      </script>
@endsection