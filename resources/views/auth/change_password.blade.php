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

<body>
   <section class="detail-page bg-image--parallax">
      <div class="container">
      <h3 class="mb-5 font-weight-700 text-effect">Change Password</h3>
      <div class="row gx-lg-5">
         <div class="col-lg-8">
         <form class="generic-form" id="form2" autocomplete="off"  method="POST"   action="{{ route('change.password') }}">
               @csrf
               <div class="row gx-5 mb-3">
                  <div class="col-lg-6 col-md-12">
                     <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" value="{{old('current_password')}}" minlength="5" maxlength="256" required class="form-control" />
                         @error('current_password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-12"></div>
                  <div class="col-lg-6 col-md-12">
                     <div class="form-group">
                        <label>New Password</label>
                        <div class="icon-wraper password-group">
                           <input type="password" name="new_password" id="password" maxlength="20" required class="password-box form-control" />
                           <div class="icon password-visibility"><i class="fa fa-eye"></i></div>
                        </div>
                        
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                     </div>
                  </div>
                   <div class="col-lg-6 col-md-12"></div>
                  <div class="col-lg-6 col-md-12">
                     <div class="form-group">
                        <label>Confirm New Password</label>
                        <div id="pac-container">
                        <div class="icon-wraper password-group">
                           <input required class="password-box form-control"  data-pristine-equals="#password" maxlength="20"  name="new_confirm_password" type="password" />
                           <div class="icon password-visibility"><i class="fa fa-eye"></i></div>
                        </div>
                        </div>
                     </div>
                  </div>
                   <div class="col-lg-6 col-md-12"></div>
                  <div class="mt-5 mb-3 text-end col-lg-6 col-12">
                      <a href="{{url()->previous()}}" class="btn btn-secondary text-white px-5 py-2 font-size-18">Cancel</a>
                     <button class="btn btn-primary px-5 py-2 font-size-18">Save</button>
                  </div>
            </form>
            </div>
            <div class="col-lg-4">
            </div>
         </div>
      </div>
   </section>
</body>
@endsection