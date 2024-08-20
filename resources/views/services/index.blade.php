@extends('layouts.app')

@section('content')
<body>
    <section class="view-property bg-gray py-5 bg-image--parallax">
        <div class="container ">
         <div class="row mb-4 mzk-row-wrap">
            <div class="col-md-6 col-8 mbl-order-1">
               <h3 class="mb-5 font-weight-700 text-effect">Manage Services</h3>
            </div>

   

            <!-- test -->
            <div class="col-md-2 col-4 text-right mbl-order-2" style="    text-align: -webkit-right;">
                 @if (Gate::allows('create_services')) 
             <a href="{{ route('services.create') }}" class="btn btn-primary">Add New</a>
             @endif
            </div>
            <!-- test -->


         </div>
            <div class="table-responsive">
                <table id="tables_id">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <!-- <th>Email</th> -->
                            <th>Contact Name</th>
                            <th>Contact Number</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($services as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->contact_name }}</td>
                            <td>{{ $service->contact_number }}</td>
                            <td>{{ $service->address }}</td>
                            <td>{{ $service->status }}</td>
                            <td>
                                <div class="d-flex align-items-center flex-nowrap gap-10">
                                <div class="icon-rounded"><a class="" data-bs-toggle="tooltip" data-bs-placement="top" title="View" href="{{ url('service-detail',enCryptData($service->id)) }}"> <i class="fa fa-eye"></i></a></div> 
                                <div class="icon-rounded"><a class="" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" href="{{ route('services.edit',$service->id) }}"> 
                                      <i class="fa fa-pencil"></i></a></div>
                                  </div>
                            </td>
                            
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>

@endsection
@section('js')

@endsection