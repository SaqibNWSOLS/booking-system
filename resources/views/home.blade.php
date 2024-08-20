@extends('layouts.app')
@section('content')
<body>
   <section class="search-page auto-fr align-items-start gap-0">
      <div style="height: 100%">
      <div class="search-filter">
        <form method="GET" action="{{url('/')}}">
         <div class="hide-filter-view"><img src="{{asset('assets/icons/cross-svgrepo-com.svg')}}" /></div>
         <div class="filter-block py-4">
            <div class="h-list justify-content-between">
               <div class="h-list align-items-center gap-10">
                  <h5 class="font-weight-600 m-0">Filter</h5>
                  <span class="badge count-badge" style="min-width: auto">{{count($services)}}</span>
               </div>
               <span class="font-size-12 font-weight-600 text-hover-primary" onclick="clearFilter('clearAll')">Clear all</span>
            </div>
         </div>

           <div class="divider"></div>
         <div class="filter-block" id="accordionExample1">
            <div class="h-list justify-content-between">
               <h6 class="font-weight-600 font-size-14 m-0">Search</h6>
               <div class="h-list gap-10">
               <div class="h-list gap-10">
                  <span class="font-size-11 link text-primary" onclick="clearFilter('title')">Clear</span>
               </div>
               <span class="arrow-down" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo"></span>
               </div>
            </div>
            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample1">
               <div class="collapse-block mt-3">
                  <div class="grid gap-0 mb-3">
                     <input id="ex2" type="text" class="form-control" name="title" id="title" class="span2" value="{{Request::query('title') }}" data-slider-min="10" data-slider-max="10000" data-slider-step="5" data-slider-value="{{Request::query('title') }}"/> 
                    
                  </div>
                
               </div>
            </div>
         </div>
         
         <div class="divider"></div>
         <div class="divider"></div>
         <div class="filter-block" id="accordionExample">
            <div class="h-list justify-content-between">
               <h6 class="font-weight-600 font-size-14 m-0">Location</h6>
               <div class="h-list gap-10">
                  <span class="font-size-11 link text-primary" onclick="clearFilter('location')">Clear</span>
                  <span class="arrow-down" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"></span>
               </div>
            </div>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
               <div class="collapse-block mt-3">
                  <div class="grid gap-10">
                     <div class="form-group m-0">
                        <input type="text" id="location" name="search" onclick="getCoordinates(this.value)" oninput="getCoordinates(this.value)" onsubmit="getCoordinates(this.value)" oninput="getCoordinates(this.value)" onpaste="getCoordinates(this.value)" onchange="getCoordinates(this.value)" value="{{Request::query('search') }}" class="form-control" />
                        <!-- <img class="icon" src="{{asset('assets/icons/magnify.svg')}}" /> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
       
         <div class="filter-block">
            <button class="btn btn-primary w-100">Filter</button>
         </div>
         </form>
      </div>
         <div class="filter-backdropv2"></div>
      </div>
      <div class="properties">
         <div class="h-list justify-content-between gap-10 mb-3 sort-filter">
            <div class="mbl-filters">
               <div class="btn btn-secondary btn-view-filter"><img class="" src="{{asset('assets/icons/filter-svgrepo-com.svg')}}" />View Filter </div>
              
            </div>
            <div class="h-list gap-10" id="icon-container">
               <p class="font-size-14 m-0 mr-2">views{{session('current_view')}}</p>
               <div class="icon-holder grid-view active">
                  <img src="{{asset('assets/icons/grid-icon.svg')}}" />
               </div>
               <div class="icon-holder list-view">
                  <img src="{{asset('assets/icons/list-icon.svg')}}" />
               </div>
            </div>
         </div>
         @if(!empty(count($services)))
         <div class="property-listing">
            @foreach($services as $service)
            <div class="property-card">
               <div class="image">
                  <img src="@if(!empty($service->serviceImages[0])){{asset('uploads/'.$service->serviceImages[0]->path)}}@else{{'https://thumbs.dreamstime.com/b/dummy-house-23129091.jpg'}}@endif" />
               </div>
               <div class="grid gap-10 px-3 property-card-details">
                  
                  <div class="flex-seprator">
                     <div class="flex-seprator">
                        <div class="name-holder">
                           <h4 class="font-size-18 m-0">
                              {{$service->title}}
                             
                               </h4>
                        </div>
                        <div class="grid gap-10">
                           <div class="auto-fr gap-10">
                              
                             <p class="text-muted m-0 font-size-12">
    {{ \Illuminate\Support\Str::words($service->description, 30) }}
</p>
                             
                           </div>
                         
                        </div>
                     </div>
                  
                     <div class="card-btn  justify-content-between mt-2">

                        <h6 class="m-0">$ {{germanNoFormat($service->price)}}</h6>
                       
                        <br>
                        <a href="{{url('service-detail',enCryptData($service->id))}}" class="btn btn-primary">Book Now!</a>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach
         </div>
         <div class="mt-5 mb-10 text-end">
            <nav aria-label="Page example">
               <ul class="pagination justify-content-end">
                  {{$services->withQueryString()->links()}}
               </ul>
            </nav>
         </div>
         @else 
         <div class="no-record-msg">
            <h4>No Services Found.</h4>
         </div>
         @endif
      </div>
   </section>
</body>
@endsection

@section('js')
 <script type="text/javascript">
function clearFilter(name) {
    if (name == 'location') {
        $('#location').val('');
    }
     else if(name=='clearAll'){
      $('#location').val('');
       
    }
}
 </script>

@endsection
