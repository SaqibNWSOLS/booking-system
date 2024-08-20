@extends('layouts.app') @section('content')
<style type="text/css">
/* 
   * Always set the map height explicitly to define the size of the div element
   * that contains the map. 
   */

#map {
    height: 90%;
}

</style>

    <section class="detail-page">
        <div class="container">
            <div class="grid gap-5 mb-4">
                <h2 class="font-weight-600 m-0">{{$service->title}}</h2>
            </div>
            <div class="slider-wraper">
                <div id="custom-accordion"> @foreach($service->serviceImages as $key=>$image)
                    <div class="image @if( $key==0){{'active'}}@endif"> <img src="{{asset('uploads/'.$image->path.'')}}" /> </div> @endforeach </div>
                <div class="h-list align-items-center justify-content-lg-end justify-content-md-end  justify-content-center gap-10 mt-3">
                    <button class="btn btn-light d-flex align-items-center gap-10" data-bs-toggle="modal" data-bs-target="#media-view"><img src="{{asset('assets/icons/see-all.svg')}}" /> <span>See All</span></button>
                    <div class="h-list align-items-center gap-10">
                        <button class="btn p-0" id="prev-button"><img src="{{asset('assets/icons/arrow-left.svg')}}" /></button>
                        <button class="btn p-0" id="next-button"><img src="{{asset('assets/icons/arrow-right.svg')}}" /></button>
                    </div>
                </div>
            </div>
            <div class="detail-page-desc mt-5">
                <div class="grid gap-40 details flex-1">
                    <div class="grid gap-10">
                        <h5 class="m-0 font-weight-600">{{$service->title}}y</h5>
                    </div>
                    <div class="divider"></div>
                    <p class="section-holder text-muted m-0" id="text-block"> {!!$service->description!!} </p>
                    <div class="divider"></div>
                  
                    <div class="divider"></div>
                    <div class="section-holder  map-holder grid gap-10" id="map-block">
                        <h5 class="font-weight-600">Map</h5>
                        <div class="col-md-12">
                            <div id="map" class="mt-4"></div>
                        </div>
                        <div class="h-list justify-content-between mt-1">
                            <p class="m-0">{{$service->address}}</p>
                        </div>
                    </div>
                </div>
                <div class="sticky-bar">
                    <div class="booking-status">
                        <form class="py-4 px-3" id="form3" action="{{route('bookings.store')}}" method="POST" > 
                            @csrf
                            <div class="d-flex flex-column mb-2">
                                <label class="font-weight-700 fs-7 mb-3">Price {{ $service->price }}</label>
                                 
                                    @error('price_id') <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div> 
                           
                            <div class="row">
                                @if(!empty(Auth::user()->id))
                                @if(Auth::user()->hasRole('Client'))
                            
                                   
                                    <input type="hidden" name="users_id" value="{{ Auth::id() }}">
                                    @else
                                     <input type="hidden" name="services_id" value="{{$service->id}}">
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-floating form-floation-select mb-2">
                                       <select class="select-customer form-control select-2" required name="users_id">
                                          <option disabled selected value="">Select below</option>
                                           @foreach($customers as $customer)
                                           <option value="{{$customer->id}}">{{$customer->name}}</option>
                                           @endforeach
                                       </select>
                                        <label for="floatingInput">Customer</label>
                                    </div>
                                </div>
                               @endif
                               @endif
                            </div>
                            <button class="btn btn-primary w-100 mt-1">Create Booking</button>
                        </form>
                    </div>
                    <ul class="list-unstyle grid gap-15 p-0 m-0 mt-5">
                        <li> <a href="#text-block" class="text-hover-primary">Summary</a> </li>
                        <li> <a href="#map-block" class="text-hover-primary">Map</a> </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>






<div class="modal fade" id="media-view" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 p-4 pb-3">
                <h5 class="modal-title font-size-20" id="exampleModalLabel">Property Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="media-for"> @foreach($service->serviceImages as $key=>$image)
                    <div class="image"> <img src="{{asset('uploads/'.$image->path.'',)}}" /> </div> @endforeach </div>
                <div class="media-nav"> @foreach($service->serviceImages as $key=>$image)
                    <div class="image"> <img src="{{asset('uploads/'.$image->path.'')}}" /> </div> @endforeach </div>
            </div>
        </div>
    </div>
</div> 

@endsection

 @section('js')
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDXGsx1M8NgD6v08sSROn2Wud8j-XKjK0U&callback=initMaps&libraries=places&v=weekly"  async  ></script>
      <script type="text/javascript">
 window.onload = function () {
         var form = document.getElementById("form3");
         
           var pristine = new Pristine(form);
         
           form.addEventListener('submit', function (e) {
             e.preventDefault();
             var valid = pristine.validate();
            if (valid==true) {
             form.submit();
            }
           
           });
       };

                $(document).on('submit', '#form2', function(e){
                    e.preventDefault();
                    var name = $('#name').val();
                    var email = $('#email').val();
                    var contactName = $('#contact_name').val();
                    var contactNumber = $('#contact_number').val();
                    var city = $('#city').val();
                    var address = $('#address').val();
                    var zip = $('#zip_code').val();
                    if(!name || !email || !contactName || !contactNumber || !city || !address || !zip){
                     /*   swal({
                            title: "Insufficient Data.",
                            text: "Please enter all fields!",
                            icon: "warning",
                        })
                            .then(function(isConfirm) {
                            if (isConfirm) {
                                console.log('comfi')
                                return false;
                            }
                        });*/
                        return false;
                    }
                    // $ajax.
                    console.log('here');
                    var $form = $(this);

                    // Let's select and cache all the fields
                    var $inputs = $form.find("input, checkbox");
                    // console.log('input', $inputs);
                    // Serialize the data in the form
                    var serializedData = $form.serialize();

                    // Let's disable the inputs for the duration of the Ajax request.
                    // Note: we disable elements AFTER the form data has been serialized.
                    // Disabled form elements will not be serialized.
                    // $inputs.prop("disabled", true);

                    // Fire off the request to /form.php
                    showPreloader();
                    $.ajax({
                        url: "{{url('customer')}}",
                        type: "post",
                        data: serializedData
                    }).done(function(response) {
                        console.log(response);
                        if(response.message == '200'){
                            hidePreloader();
                           Swal.fire(
                    'Success!',
                    'Customer has been added successfully.',
                    'success'
                );
                                    $('#customer-modal').modal('hide');
                                   $(".select-customer").prepend('<option value='+response.id+'>'+response.name+'</option>');

                                   $('#form2').reset();
                         
                        }else{
                            hidePreloader();
                            swal({
                                title: "Failed.",
                                text: "Unable to add the customer.",
                                icon: "error",
                            })
                        }
                        console.log('response', response.message);
                    });

                    // alert('Customer Added Successfully');
                    // return;
                });

         "use strict";
/**
 * @license
 * Copyright 2019 Google LLC. All Rights Reserved.
 * SPDX-License-Identifier: Apache-2.0
 */
Object.defineProperty(exports, "__esModule", { value: true });
function initMaps() {
    var myLatLng = { lat: {{$service->latitude}}, lng: {{$service->longitude}} };
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 15,
        center: myLatLng,
          mapTypeId: 'satellite'

    });
    new google.maps.Marker({
        position: myLatLng,
        map: map,
        title:' {{$service->address}}',
    });
}
window.initMaps = initMaps;

      </script>

@endsection
