<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $radius = 25)
    {
        $latitude = session('latitude');
        $longitude = session('longitude');

        $query = Service::where('status', 'Active');

        if (!empty($request->search) && !empty($latitude) && !empty($longitude)) {
            $query->selectRaw('id, title, address, latitude, longitude,
    (ST_Distance_Sphere(point(longitude,latitude),point(?,?))/1000) AS distance', [$longitude, $latitude])->having("distance", "<", $radius);
        }
        if (!empty($request->title)) {

            $query->where('title', 'LIKE', '%' . $request->title . '%');
        }

        $services = $query->paginate(10);
        return view('home', compact('services'));
    }

    public function serviceDetail($id)
    {
        $id = deCryptData($id);

        $service = Service::where('id', $id)->first();
        $customers = User::role('Client')->get();

        return view('service_detail', compact('service', 'customers'));

    }

    public function setLocation(Request $request)
    {

        session(['latitude' => $request->latitude]);

        session(['longitude' => $request->longitude]);
    }
}
