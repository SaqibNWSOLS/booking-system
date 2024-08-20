@extends('layouts.app')

@section('content')
<body>
    <section class="view-property bg-gray py-5 bg-image--parallax">
        <div class="container ">
         <div class="row mb-4 mzk-row-wrap">
            <div class="col-md-6 col-8 mbl-order-1">
               <h3 class="mb-5 font-weight-700 text-effect">Manage Bookings</h3>
            </div>

   

           


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

                        @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->title }}</td>
                            <td>{{ $booking->contact_name }}</td>
                            <td>{{ $booking->contact_number }}</td>
                            <td>{{ $booking->address }}</td>
                            <td>{{ $booking->status }}</td>
                            <td>
                                <div class="d-flex align-items-center flex-nowrap gap-10">
                                <div class="icon-rounded"><a class="" data-bs-toggle="tooltip" data-bs-placement="top" title="View" href="#"> <i class="fa fa-eye"></i></a></div> 
                               
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