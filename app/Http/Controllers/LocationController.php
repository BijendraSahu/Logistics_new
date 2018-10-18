<?php

namespace App\Http\Controllers;

use App\LocationMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LocationController extends Controller
{
    public function index()
    {
        return view('adminview.location.view_location')->with('locations', LocationMaster::getActiveLocation());
    }

    public function create()
    {
        return view('adminview.location.create_location');
    }

    public function store(Request $request)
    {
        $ln = new LocationMaster();
        if (!$ln->checkLocationName(request('location'))) {
            return Redirect::back()->withInput()->withErrors('Location already exists in the system. Please type a different Location.');
        } else {
            $location = new LocationMaster();
            $location->type = request('type');
            $location->name = request('location');
            $location->save();
            return redirect('location')->with('message', 'Location has been added...!');
        }
    }

    public
    function destroy($id)
    {
        $location = LocationMaster::find($id);
        $location->is_active = 0;
        $location->save();
        return redirect('location')->with('message', 'Location has been deleted...!');

    }

    public function edit($id)
    {
        $location = LocationMaster::find($id);
        return view('adminview.location.edit_location')->with(['location' => $location]);
    }

    public function update($id, Request $request)
    {
        $ln = new LocationMaster();
        if (!$ln->echeckLocationName(request('location'), $id)) {
            return Redirect::back()->withInput()->withErrors('Location already exists in the system. Please type a different Location.');
        } else {
            $location = LocationMaster::find($id);
            $location->type = request('type');
            $location->name = request('location');
            $location->save();
            return redirect('location')->with('message', 'Location has been updated...!');
        }

    }
}
