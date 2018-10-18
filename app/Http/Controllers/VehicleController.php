<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VehicleController extends Controller
{
    public function index()
    {
        return view('adminview.vehicle.view_vehicle')->with('vehicles', Vehicle::getActiveVehicle());
    }

    public function create()
    {
        return view('adminview.vehicle.create_vehicle');
    }

    public function store(Request $request)
    {
        $unitmaster = new Vehicle();
        if (!$unitmaster->checkVehicleName(request('vehicle_no'))) {
            return Redirect::back()->withInput()->withErrors('Vehicle No already exists in the system. Please type a different Vehicle No.');
        } else {
            $vehicle = new Vehicle();
            $vehicle->vehicle_no = request('vehicle_no');
            $vehicle->save();
            return redirect('vehicle')->with('message', 'Vehicle has been added...!');
        }
    }

    public
    function destroy($id)
    {
        $Units = Vehicle::find($id);
        $Units->is_active = 0;
        $Units->save();
        return redirect('vehicle')->with('message', 'Vehicle has been deleted...!');

    }

    public function edit($id)
    {
        $vehicle = Vehicle::find($id);
        return view('adminview.vehicle.edit_vehicle')->with(['vehicle' => $vehicle]);
    }

    public function update($id, Request $request)
    {
        $vh = new Vehicle();
        if (!$vh->echeckVehicleName(request('vehicle_no'), $id)) {
            return Redirect::back()->withInput()->withErrors('Vehicle No already exists in the system. Please type a different Vehicle No.');
        } else {
            $vehicle = Vehicle::find($id);
            $vehicle->vehicle_no = request('vehicle_no');
            $vehicle->save();
            return redirect('vehicle')->with('message', 'Vehicle has been updated...!');
        }
    }
}
