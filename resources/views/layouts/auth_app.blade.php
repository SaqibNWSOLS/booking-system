<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Booking System</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link
         href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
         rel="stylesheet"
         integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
         crossorigin="anonymous"
         />
      <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/slick.css')}}">
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
      <!-- <link rel="stylesheet" href="assets/css/accordion.css"> -->
      <!-- <link rel="stylesheet" href="assets/css/liteAccordion.css"> -->
      <link rel="stylesheet" href="{{asset('assets/css/bootstrap-slider.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/editor.css')}}">
      <link id="skin-default" rel="stylesheet" href="{{asset('assets/dropzone/css/dropzone.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
      <style type="text/css">
         .text-help {
         color: red;
         }
      </style>
   </head>
   @yield('content')
   <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
      crossorigin="anonymous"
      ></script>
   <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
   <script src="{{asset('assets/js/slick.js')}}"></script>
   <script src="{{asset('assets/js/bootstrap-slider.js')}}"></script>
   <script src="{{asset('assets/js/bootstrap-datepicker.js')}}"></script>
   <script src="{{asset('assets/js/editor.js')}}"></script>
   <script src="{{asset('assets/pristine_master/dist/pristine.min.js')}}"></script>
   <script src="{{url("public/assets/dropzone/js/bootstrap.min.js")}}"></script>
   <script src="{{url("public/assets/dropzone/js/dropzone.js")}}"></script>
   <script src="{{url("public/assets/dropzone/js/dropzone-script.js")}}"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
      @if(!empty(session('success')))
      <script type="text/javascript">
         Swal.fire(
           'Success!',
           '<?php echo session('success') ?>',
           'success'
         )
      </script>
      @endif
      @if(!empty(session('error')))
      <script type="text/javascript">
         Swal.fire(
           'Danger!',
           '<?php echo session('error') ?>',
           'error'
         )
      </script>
      @endif
      @if(!empty(session('warning')))
      <script type="text/javascript">
         Swal.fire(
           'Warning!',
           '<?php echo session('warning') ?>',
           'warning'
         )
      </script>
      @endif
   <script>
      window.onload = function () {
      
      var form = document.getElementById("form1");
      
      var pristine = new Pristine(form);
      
      form.addEventListener('submit', function (e) {
      e.preventDefault();
      var valid = pristine.validate();
      if (valid==true) {
      form.submit();
      }
      
      });
      
      
      };
   </script>
   <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC6X9qZI8tU82Zmi16w-hcfVm4VdM_Uoxg&callback=initMap&libraries=places&v=weekly"
      async
      ></script>
   <script type="text/javascript">
      "use strict";
      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
      Object.defineProperty(exports, "__esModule", { value: true });
      function initMap() {
        var map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: 50.064192, lng: -130.605469 },
            zoom: 3,
        });
        var card = document.getElementById("pac-card");
        var originLatitude = document.getElementById('s_latitude');
      var originLongitude = document.getElementById('s_longitude');
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
        var center = { lat: 50.064192, lng: -130.605469 };
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
            componentRestrictions: { country: "DE" },
            fields: ["address_components", "geometry", "icon", "name"],
            strictBounds: false,
            types: ["establishment"],
        };
        var autocomplete = new google.maps.places.Autocomplete(input, options);
        // Set initial restriction to the greater list of countries.
        autocomplete.setComponentRestrictions({
            country: ["DE", "pr", "vi", "gu", "mp"],
        });
        var southwest = { lat: 5.6108, lng: 136.589326 };
        var northeast = { lat: 61.179287, lng: 2.64325 };
        var newBounds = new google.maps.LatLngBounds(southwest, northeast);
        autocomplete.setBounds(newBounds);
        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById("infowindow-content");
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
        });
        autocomplete.addListener("place_changed", function () {
            infowindow.close();
            marker.setVisible(false);
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
            }
            else {
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
            infowindowContent.children["place-name"].textContent = place.name;
            infowindowContent.children["place-address"].textContent = address;
            infowindow.open(map, marker);
        });
        // Sets a listener on a given radio button. The radio buttons specify
        // the countries used to restrict the autocomplete search.
        function setupClickListener(id, countries) {
            var radioButton = document.getElementById(id);
            radioButton.addEventListener("click", function () {
                autocomplete.setComponentRestrictions({ country: countries });
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
      
   </script>
   <script>
      $(document).ready(function(){
          $("#banner-slider").slick({
              slideToShow: 1,
              SlideToScroll: 1,
              dots: false,
              arrows: false,
          });
      
          $("#testimonial-slider").slick({
              slideToShow: 1,
              SlideToScroll: 1,
              dots: false,
              arrows: true,
          });
      
          $(".property-slider").slick({
              slidesToShow: 7,
              SlidesToScroll: 1,
              dots: false,
              arrows: true,
              infinite: false
          })
      
          $('input[name="daterange"]').daterangepicker();
      
          $('.datepicker').datepicker();
      
          $(".select-2").select2();
      
          $('.icon-holder').on('click',function(e) {
              if ($(this).hasClass('grid-view')) {
                  $('body').removeClass('list-preview').addClass('grid-preview');
                  $('.list-view').removeClass("active");
                  $(this).addClass("active")
              }
              else if($(this).hasClass('list-view')) {
                  $('body').removeClass('grid-preview').addClass('list-preview');
                  $('.grid-view').removeClass("active");
                  $(this).addClass("active")
              }
          });
      
          $("#custom-accordion .image").on("click", function(){
              $(".image").removeClass("active");
              $(this).addClass("active");
          })
      
          var items = $('div.image');
      
          var currentItem = items.filter('.active');
          $('#next-button').on('click', function() {
              var nextItem = currentItem.next();
              currentItem.removeClass('active');
              if ( nextItem.length ) {
                  currentItem = nextItem.addClass('active');
              } else {
                  // If you want it to loop around
                  currentItem = items.first().addClass('active');
              }
          });
      
          $('#prev-button').on('click', function() {
              var prevItem = currentItem.prev();
              currentItem.removeClass('active');
              if ( prevItem.length ) {
                  currentItem = prevItem.addClass('active');
              } else {
                  // If you want it to loop around
                  currentItem = items.first().addClass('active');
              }
          });
      
          $("#ex2").slider({});
      
          $('#showPass').on('click', function(){
              var passInput=$("#passInput");
              if(passInput.attr('type')==='password')
                  {
                  passInput.attr('type','text');
                  $(this).parent().addClass("text-visible")
              }else{
                  passInput.attr('type','password');
                  $(this).parent().removeClass("text-visible")
              }
          })
      
      
          $("div#myId").dropzone(  if ($(elm).exists()) {
        $(elm).each(function () {
          var maxFiles = $(elm).data('max-files'),
              maxFiles = maxFiles ? maxFiles : null;
          var maxFileSize = $(elm).data('max-file-size'),
              maxFileSize = maxFileSize ? maxFileSize : 256;
          var acceptedFiles = $(elm).data('accepted-files'),
              acceptedFiles = acceptedFiles ? acceptedFiles : null;
          var def = {
            autoDiscover: false,
            maxFiles: maxFiles,
            maxFilesize: maxFileSize,
            acceptedFiles: acceptedFiles
          },
              attr = opt ? extend(def, opt) : def;
          $(this).addClass('dropzone').dropzone(attr);
        });
      });
      
          $("#txtEditor").Editor();
      
      });
      
      $(function() {
          function count($this){
              var current = parseInt($this.html(), 10);
              current = current + 20;
      
          $this.html(++current);
          if(current > $this.data('count')){
              $this.html($this.data('count'));
          } else {    
              setTimeout(function(){count($this)}, 10);
          }
      }        
      
      $(".stat-count").each(function() {
          $(this).data('count', parseInt($(this).html(), 10));
          $(this).html('0');
          count($(this));
      });
      
      
      });
   </script>