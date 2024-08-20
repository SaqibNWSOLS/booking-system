<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Requests\Service\ServiceStore;
use App\Http\Requests\Service\ServiceUpdate;
use Auth;
use App\Models\ServiceImage;

class ServiceController extends Controller
{
    public function index(){

        $services=Service::get();

        return view('services.index',compact('services'));
    }


    public function create(){

        return view('services.create');
    }


    public function edit(Service $service){

       return view('services.edit',compact('service'));
    }

    public function store(ServiceStore $request){

        $service=new Service();
        $service->users_id=Auth::id();
        $service->title=$request->title;
        $service->slug=generateSlug($request->title);
        $service->price=$request->price;
        $service->description=$request->description;
        $service->email=$request->email;
        $service->contact_name=$request->contact_name;
        $service->contact_number=$request->contact_number;
        $service->address=$request->address;
        $service->latitude=$request->latitude;
        $service->longitude=$request->longitude;
        $service->status=$request->status;

        $service->save();

        $serviceImage=ServiceImage::where('users_id',Auth::id())->whereNull('services_id')->update(array('services_id' => $service->id));

        return redirect('services')->with('success','Service has been added successfully!');


    }

    public function update(ServiceUpdate $request,Service $service){

         $service->users_id=Auth::id();
        $service->title=$request->title;
        $service->slug=generateSlug($request->title);
        $service->price=$request->price;
        $service->description=$request->description;
        $service->email=$request->email;
        $service->contact_name=$request->contact_name;
        $service->contact_number=$request->contact_number;
        $service->address=$request->address;
        $service->latitude=$request->latitude;
        $service->longitude=$request->longitude;
        $service->status=$request->status;

        $service->save();

        $serviceImage=ServiceImage::where('users_id',Auth::id())->whereNull('services_id')->update(array('services_id' => $service->id));

        return redirect('services')->with('success','Service has been updated successfully!');
    }
}