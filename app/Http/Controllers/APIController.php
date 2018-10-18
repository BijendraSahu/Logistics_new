<?php

namespace App\Http\Controllers;

use App\ClientRequest;
use App\ClientUnload;
use App\LocationMaster;
use App\ManagerRequest;
use App\Material;
use App\MaterialType;
use App\PetrolOrder;
use App\Unit;
use App\User;
use App\UserMaster;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class APIController extends Controller
{

    /**************Rest API Function**************/
    public function sendResponse($result, $message)
    {
        $response = [
            'status' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $code);
    }

    /**************Rest API Function**************/

    /*******************User/Registration/Login*************************/
    public function getlogin(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $mobile = request('mobile');
        $password = md5(request('password'));
        $user = DB::selectone("SELECT * FROM `users` WHERE (is_active = 1 and contact = '$mobile' and password = '$password')");
        if (isset($user)) {
            return $this->sendResponse($user, 'User Record');
        } else {
            return $this->sendError('Mobile Number or Password is Invalid', '');
        }
    }

    public function getregister(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'user_type' => 'required',
            'type' => 'required',
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $check_contact = UserMaster::where(['contact' => request('mobile')])->first();
        if (isset($check_contact)) {
            return $this->sendError('Contact no already exist...', '');
        } else {
            $otp = rand(100000, 999999);
            $user = new UserMaster();
            $user->user_type = request('user_type');
            $user->name = request('name');
            $user->type = request('type');
            $user->contact = request('mobile');
            $user->password = md5(request('password'));
            $user->otp = $otp;
            $file = $request->file('profile_img');
            if ($request->file('profile_img') != null) {
                $destination_path = 'u_img/' . $user->id . '/';
                $filename = str_random(6) . '_' . $file->getClientOriginalName();
                $file->move($destination_path, $filename);
                $user->profile_img = $filename;
            }
            $user->save();
            $user_n = UserMaster::find($user->id);
            file_get_contents("http://mysms.msg24.in/api/mt/SendSMS?user=ASHISH011&password=123456&senderid=SMCLOG&channel=Trans&DCS=0&flashsms=0&number=$user->contact&text=Dear%20user,%20otp%20to%20verify%20your%20number%20is%20$otp&route=27");
            return $this->sendResponse($user_n, 'Registration has been successful...');
        }
    }

    public function edit_profile(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = UserMaster::find(request('user_id'));
        if (isset($user)) {
            $name = request('name');
            $password = request('password');
            $user->name = isset($name) ? $name : $user->name;
            $user->password = isset($password) ? $password : $user->password;
            $file = $request->file('profile_img');
            if ($request->file('profile_img') != null) {
                $destination_path = 'u_img/' . $user->id . '/';
                $filename = str_random(6) . '_' . $file->getClientOriginalName();
                $file->move($destination_path, $filename);
                $user->profile_img = $filename;
            }
            $user->save();
            $users = UserMaster::find($user->id);
            return $this->sendResponse($users, 'Profile has been updated...');
        } else {
            return $this->sendError('No record found', '');
        }
    }

    public function change_password(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = request('user_id');
        $password = request('password');
        $user = UserMaster::find($user_id);
        if ($user != null) {
            $user->password = md5($password);
            $user->save();
            return $this->sendResponse($user, 'Password has been changed..!');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function forgetp()
    {
        $otp = rand(100000, 999999);
        $contact = request('contact');
        $user = UserMaster::where(['contact' => $contact])->first();
        if (isset($user)) {
            $user->password = md5($otp);
            $user->save();
            file_get_contents("http://mysms.msg24.in/api/mt/SendSMS?user=ASHISH011&password=123456&senderid=SMCLOG&channel=Trans&DCS=0&flashsms=0&number=$user->contact&text=Dear%20user,%20Password%20to%20login%20into%20Logistics%20is%20$otp&route=27");
            return $this->sendResponse($user, 'Password has been send to register number');
        } else {
            return $this->sendError('Incorrect Contact', '');
        }
    }

    public function sendotp()
    {
        $otp = rand(100000, 999999);
        $contact = request('contact');
        $user = UserMaster::where(['contact' => $contact])->first();
        if (isset($user)) {
            $user->otp = $otp;
            $user->save();
            file_get_contents("http://mysms.msg24.in/api/mt/SendSMS?user=ASHISH011&password=123456&senderid=SMCLOG&channel=Trans&DCS=0&flashsms=0&number=$user->contact&text=Dear%20user,%20otp%20to%20verify%20your%20number%20is%20$otp&route=27");
            $ret['response'] = 'otp has been send';
            echo json_encode($ret);
        } else {
            return $this->sendError('Incorrect Contact', '');
        }
    }

    public function verify_otp()
    {
        $otp = request('otp');
        $user = UserMaster::where(['otp' => $otp])->first();
        if (isset($user)) {
            $user->is_verified = 1;
            $user->save();
            $ret['response'] = 'Your number has been verified';
            echo json_encode($ret);
        } else {
            $ret['response'] = 'Incorrect otp';
            echo json_encode($ret);
        }
    }
    /*******************User/Registration/Login*************************/

    /**************Location Master**********************/
    public function create_location(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $location = new LocationMaster();
        $location->type = request('type');
        $location->name = request('name');
        $location->save();
        return $this->sendResponse($location, 'Location has been saved');
    }

    public function getalllocation()
    {
        $client_requests = LocationMaster::where(['is_active' => 1])->get();
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Location List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getlocation(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'location_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = LocationMaster::find(request('location_id'));
        if (isset($material) > 0) {
            return $this->sendResponse($material, 'Location Record');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function updatelocation(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'location_id' => 'required',
            'type' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = LocationMaster::find(request('location_id'));
        if (isset($material) > 0) {
            $material->type = request('type');
            $material->name = request('name');
            $material->save();
            return $this->sendResponse($material, 'Location has been updated');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function deletelocation(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'location_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = LocationMaster::find(request('location_id'));
        if (isset($material) > 0) {
            $material->is_active = 0;
            $material->save();
            return $this->sendResponse($material, 'Location has been deleted');
        } else {
            return $this->sendError('No record available', '');
        }
    }
    /**************Location Master**********************/

    /**************Material**********************/
    public function create_material(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'location_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = new Material();
        $material->name = request('name');
        $material->location_id = request('location_id');
        $material->save();
        return $this->sendResponse($material, 'Material has been saved');
    }

    public function getallmaterials()
    {
        $client_requests = Material::where(['is_active' => 1])->get();
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Material List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getmaterial(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'material_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Material::find(request('material_id'));
        if (isset($material) > 0) {
            return $this->sendResponse($material, 'Material Record');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function updatematerial(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'material_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Material::find(request('material_id'));
        if (isset($material) > 0) {
            $material->name = request('name');
            $material->location_id = request('location_id');
            $material->save();
            return $this->sendResponse($material, 'Material has been updated');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function deletematerial(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'material_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Material::find(request('material_id'));
        if (isset($material) > 0) {
            $material->is_active = 0;
            $material->save();
            return $this->sendResponse($material, 'Material has been deleted');
        } else {
            return $this->sendError('No record available', '');
        }
    }
    /**************Material**********************/


    /**************Material Type**********************/
    public function create_material_type(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'type' => 'required',
            'material_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $materialt = new MaterialType();
        $materialt->material_id = request('material_id');
        $materialt->type = request('type');
        $materialt->save();
        return $this->sendResponse($materialt, 'Material type has been saved');
    }

    public function getallmaterials_type()
    {
        $materialt = MaterialType::where(['is_active' => 1])->get();
        if (count($materialt) > 0) {
            return $this->sendResponse($materialt, 'Material Type List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getallmaterials_type_mid(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'material_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material_id = request('material_id');
        $materialt = MaterialType::where(['is_active' => 1, 'material_id' => $material_id])->get();
        if (count($materialt) > 0) {
            return $this->sendResponse($materialt, 'Material Type List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getmaterial_type(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'material_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = MaterialType::find(request('material_type_id'));
        if (isset($material) > 0) {
            return $this->sendResponse($material, 'Material Type Record');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function updatematerial_type(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'material_type_id' => 'required',
            'material_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = MaterialType::find(request('material_type_id'));
        if (isset($material) > 0) {
            $material->material_id = request('material_id');
            $material->type = request('type');
            $material->save();
            return $this->sendResponse($material, 'Material type has been updated');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function deletematerial_type(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'material_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = MaterialType::find(request('material_type_id'));
        if (isset($material) > 0) {
            $material->is_active = 0;
            $material->save();
            return $this->sendResponse($material, 'Material type has been deleted');
        } else {
            return $this->sendError('No record available', '');
        }
    }
    /**************Material Type**********************/


    /**************Material Unit**********************/
    public function create_unit(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'unit' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $materialt = new Unit();
        $materialt->unit = request('unit');
        $materialt->save();
        return $this->sendResponse($materialt, 'Material Unit has been saved');
    }

    public function getallunit()
    {
        $materialt = Unit::where(['is_active' => 1])->get();
        if (count($materialt) > 0) {
            return $this->sendResponse($materialt, 'Material Unit List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getunit(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'unit_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Unit::find(request('unit_id'));
        if (isset($material) > 0) {
            return $this->sendResponse($material, 'Material Unit Record');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function updateunit(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'unit' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Unit::find(request('unit_id'));
        if (isset($material) > 0) {
            $material->unit = request('unit');
            $material->save();
            return $this->sendResponse($material, 'Material Unit has been updated');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function deleteunit(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'unit_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Unit::find(request('unit_id'));
        if (isset($material) > 0) {
            $material->is_active = 0;
            $material->save();
            return $this->sendResponse($material, 'Material Unit has been deleted');
        } else {
            return $this->sendError('No record available', '');
        }
    }
    /**************Material Unit**********************/

    /****************************************Client*******************************/

    /**************client_request**********************/
    public function client_request_create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'location_id' => 'required',
            'material_id' => 'required',
            'material_type_id' => 'required',
            'qty' => 'required',
            'unit_id' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $crequest = new ClientRequest();
        $crequest->location_id = request('location_id');
        $crequest->material_id = request('material_id');
        $crequest->material_type_id = request('material_type_id');
        $crequest->qty = request('qty');
        $crequest->unit_id = request('unit_id');
        $crequest->address = request('address');
        $crequest->created_by = request('user_id');
        $crequest->save();
        return $this->sendResponse($crequest, 'Request has been send');
    }

    public function getclient_request(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = request('user_id');
        $client_requests = DB::select("SELECT c.id, (SELECT l.name from location_master l WHERE c.location_id = l.id) as location, (SELECT m.name from material m WHERE c.material_id = m.id) as material,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, c.is_active, c.address, c.is_approved, c.qty, c.created_time from client_request c where c.created_by = $user_id");
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Client Requests List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getAllclient_request(Request $request)
    {
        $client_requests = DB::select("SELECT c.id, (SELECT l.name from location_master l WHERE c.location_id = l.id) as location, (SELECT m.name from material m WHERE c.material_id = m.id) as material,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, c.is_active, c.address, c.is_approved, c.qty, c.created_time from client_request c");
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Client Requests List');
        } else {
            return $this->sendError('No record available', '');
        }
    }
    /**************client_request API**********************/

    /**************client_unload_request**********************/
    public function client_unload_create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'location' => 'required',
            'material_id' => 'required',
            'material_type_id' => 'required',
            'qty' => 'required',
            'unit_id' => 'required',
            'vehicle_no' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $crequest = new ClientUnload();
        $crequest->challan_no = request('challan_no');
        //$crequest->location_id = request('location_id');
        $crequest->location = request('location');
        $crequest->material_id = request('material_id');
        $crequest->material_type_id = request('material_type_id');
        $crequest->unload_qty = request('qty');
        $crequest->unit_id = request('unit_id');
        //$crequest->vehicle_id = request('vehicle_id');
        $crequest->vehicle_no = request('vehicle_no');
        $crequest->unload_by = request('user_id');
//        $crequest->is_loaded_select = request('is_loaded_select');
        $crequest->load_challan_no = request('load_challan_no');
        $crequest->load_qty = request('load_qty');
        $crequest->load_unit = request('load_unit');
        $crequest->crusher = request('crusher');
        $crequest->etp_no = request('etp_no');
        $crequest->q_m = request('q_m');
        $crequest->unloaded_time = Carbon::now('Asia/Kolkata');
        $crequest->save();
        return $this->sendResponse($crequest, 'Material has been unloaded');
    }

    public function getclient_unload(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = request('user_id');
//        $client_requests = DB::select("SELECT c.id, c.challan_no, (SELECT m.name from material m WHERE c.material_id = m.id) as material,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, (SELECT v.vehicle_no from vehicle v where c.vehicle_id = v.id) as vehicle_no, (SELECT lm.name from location_master lm WHERE c.location_id = lm.id) as location, c.is_active, c.unload_qty, c.unloaded_time from client_unload c where c.unload_by = $user_id");
        $client_requests = DB::select("SELECT c.id, c.challan_no, (SELECT m.name from material m WHERE c.material_id = m.id) as material,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, c.vehicle_no, c.location, c.is_active, c.unload_qty, c.unloaded_time,c.etp_no, c.q_m from client_unload c where c.unload_by = $user_id");
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Client Requests List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getAllclient_unload(Request $request)
    {
        $client_requests = DB::select("SELECT c.id, c.challan_no, (SELECT m.name from material m WHERE c.material_id = m.id) as material,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit,  c.vehicle_no, c.location, c.is_active, c.unload_qty, c.unloaded_time, c.etp_no, c.q_m from client_unload c");
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Client Requests List');
        } else {
            return $this->sendError('No record available', '');
        }
    }
    /**************client_unload_request API**********************/

    /****************************************Client*******************************/


    /****************************************Manager*******************************/
    /**************manager_request**********************/
    public function manager_request_create(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
            'location' => 'required',
            'material_id' => 'required',
            'material_type_id' => 'required',
            'qty' => 'required',
            'unit_id' => 'required',
            'destination_address' => 'required',
            'vehicle_no' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $mrequest = new ManagerRequest();
        $mrequest->challan_no = request('challan_no');
//        $mrequest->location_id = request('location_id');
        $mrequest->location = request('location');
        $mrequest->material_id = request('material_id');
        $mrequest->material_type_id = request('material_type_id');
        $mrequest->load_qty = request('qty');
        $mrequest->unit_id = request('unit_id');
        $mrequest->destination_address = request('destination_address');
//        $mrequest->estimate_deliver_time = Carbon::parse(request('estimate_deliver_time'))->format('Y-m-d h:i');
//        $mrequest->vehicle_id = request('vehicle_id');
        $mrequest->vehicle_no = request('vehicle_no');
        $mrequest->created_by = request('user_id');
        $mrequest->etp_no = request('etp_no');
        $mrequest->q_m = request('q_m');
        $mrequest->loaded_time = Carbon::now('Asia/Kolkata');
        $mrequest->save();

//        $vehicle = Vehicle::find($mrequest->vehicle_id);
//        $vehicle->is_loaded = 1;
//        $vehicle->save();

        return $this->sendResponse($mrequest, 'Item has been loaded');
    }

    public function getmanager_request(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = request('user_id');
        $mrequest = DB::select("SELECT c.id, c.challan_no,  c.vehicle_no, c.location, (SELECT m.name from material m WHERE c.material_id = m.id) as material,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, c.is_active, c.load_qty, c.destination_address, c.estimate_deliver_time, c.loaded_time, c.etp_no, c.q_m from manager_request c where c.created_by = $user_id");
        if (count($mrequest) > 0) {
            return $this->sendResponse($mrequest, 'Manager Requests List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getLoaded_items_by_v_no(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'v_no' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $v_no = request('v_no');
        $mrequest = DB::selectOne("SELECT c.id, c.challan_no, (SELECT l.name from location_master l WHERE c.location_id = l.id) as location, (SELECT m.name from material m WHERE c.material_id = m.id) as material, (SELECT v.vehicle_no from vehicle v WHERE c.vehicle_id = v.id) as vehicle_no,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, c.is_active, c.load_qty, c.destination_address, c.estimate_deliver_time, c.loaded_time, c.location_id,c.material_id,c.material_type_id,c.unit_id,c.vehicle_id,c.created_by from manager_request c where c.challan_no = '$v_no'");
        if (isset($mrequest) > 0) {
            return $this->sendResponse($mrequest, 'Loaded Item');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getLoaded_items_by_vehicle_id(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vehicle_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $vehicle_id = request('vehicle_id');
        $mrequest = DB::selectOne("SELECT c.id, c.challan_no, (SELECT l.name from location_master l WHERE c.location_id = l.id) as location, (SELECT m.name from material m WHERE c.material_id = m.id) as material, (SELECT v.vehicle_no from vehicle v WHERE c.vehicle_id = v.id) as vehicle_no,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, c.is_active, c.load_qty, c.destination_address, c.estimate_deliver_time, c.loaded_time, c.location_id,c.material_id,c.material_type_id,c.unit_id,c.vehicle_id,c.created_by, c.etp_no, c.q_m from manager_request c where c.vehicle_id = '$vehicle_id'");
        if (isset($mrequest) > 0) {
            return $this->sendResponse($mrequest, 'Loaded Item');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getAllmanager_request(Request $request)

    {
        $mrequest = DB::select("SELECT c.id, c.challan_no, (SELECT l.name from location_master l WHERE c.location_id = l.id) as location, (SELECT m.name from material m WHERE c.material_id = m.id) as material,  (SELECT mt.type from material_type mt WHERE c.material_type_id = mt.id) as m_type, (SELECT u.unit from unit u where c.unit_id = u.id) as unit, c.is_active, c.load_qty, c.destination_address, c.estimate_deliver_time, c.loaded_time, c.etp_no, c.q_m from manager_request c");
        if (count($mrequest) > 0) {
            return $this->sendResponse($mrequest, 'Manager Requests List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getallvehicleloaded()
    {
//        $client_requests = Vehicle::where(['is_active' => 1, 'is_loaded' => 1])->get();
        $client_requests = DB::select("select v.id, v.vehicle_no from vehicle v, manager_request mr where mr.vehicle_id = v.id and v.is_loaded = 1 and v. is_active = 1");

        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Loaded Vehicle List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getallvehicleunloaded()
    {
//        $client_requests = Vehicle::where(['is_active' => 1, 'is_loaded' => 0])->get();
        $client_requests = DB::select("select DISTINCT vehicle_no, id from vehicle where is_active = 1 and is_loaded = 0");
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Free Vehicle List');
        } else {
            return $this->sendError('No record available', '');
        }
    }


    public function switch_vehicle(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'exist_vehicle_id' => 'required',
            'new_vehicle_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material_load = ManagerRequest::where(['vehicle_id' => request('exist_vehicle_id')])->orderBy('id', 'desc')->first();
        if (isset($material_load)) {
            $material_load->vehicle_id = request('new_vehicle_id');
            $material_load->save();

            $vehicle = Vehicle::find(request('new_vehicle_id'));
            $vehicle->is_loaded = 1;
            $vehicle->save();

            $vehicle_new = Vehicle::find(request('exist_vehicle_id'));
            $vehicle_new->is_loaded = 0;
            $vehicle_new->save();
            return $this->sendResponse($material_load, 'Vehicle has been switched now');
        } else {
            return $this->sendError('No record available', '');
        }
    }
    /**************client_request API**********************/
    /****************************************Manager*******************************/

    /****************************************Admin*******************************/
    public function getLoaded_request(Request $request)
    {
        $posts = DB::select("SELECT * FROM `manager_request` ORDER BY id DESC");
        $numrows = count($posts);
        $rowsperpage = 10;
        $totalpages = ceil($numrows / $rowsperpage);
        if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
            $currentpage = (int)$_GET['currentpage'];
        } else {
            $currentpage = 1;  // default page number
        }
        if ($currentpage < 1) {
            $currentpage = 1;
        }
        $offset = ($currentpage - 1) * $rowsperpage;
        $s = "SELECT * FROM `manager_request` ORDER BY id DESC LIMIT $offset,$rowsperpage";
        $posts = DB::select($s);
        if (count($posts) > 0) {
            return $this->sendResponse($posts, 'Material Loaded List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getUnloaded_request(Request $request)
    {
        $posts = DB::select("SELECT * FROM `client_unload` ORDER BY id DESC");
        $numrows = count($posts);
        $rowsperpage = 10;
        $totalpages = ceil($numrows / $rowsperpage);
        if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
            $currentpage = (int)$_GET['currentpage'];
        } else {
            $currentpage = 1;  // default page number
        }
        if ($currentpage < 1) {
            $currentpage = 1;
        }
        $offset = ($currentpage - 1) * $rowsperpage;
        $s = "SELECT * FROM `client_unload` ORDER BY id DESC LIMIT $offset,$rowsperpage";
        $posts = DB::select($s);
        if (count($posts) > 0) {
            return $this->sendResponse($posts, 'Material UnLoaded List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getAllClient_requests(Request $request)
    {
        $posts = DB::select("SELECT * FROM `client_request` ORDER BY id DESC");
        $numrows = count($posts);
        $rowsperpage = 10;
        $totalpages = ceil($numrows / $rowsperpage);
        if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
            $currentpage = (int)$_GET['currentpage'];
        } else {
            $currentpage = 1;  // default page number
        }
        if ($currentpage < 1) {
            $currentpage = 1;
        }
        $offset = ($currentpage - 1) * $rowsperpage;
        $s = "SELECT * FROM `client_request` ORDER BY id DESC LIMIT $offset,$rowsperpage";
        $posts = DB::select($s);
        if (count($posts) > 0) {
            return $this->sendResponse($posts, 'Material Requests List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function getCompareList(Request $request)
    {
        $posts = DB::select("SELECT m.name as m_name, mt.type as m_type, cu.unload_qty, mr.load_qty, u.unit, v.vehicle_no, mr.estimate_deliver_time, cu.unloaded_time, mr.loaded_time FROM manager_request mr, client_unload cu, vehicle v, material m, material_type mt, unit u WHERE mr.vehicle_id = cu.vehicle_id and cu.material_id = m.id and cu.material_type_id = mt.id and cu.vehicle_id = v.id and cu.unit_id = u.id ORDER BY cu.unloaded_time DESC");
        $numrows = count($posts);
        $rowsperpage = 10;
        $totalpages = ceil($numrows / $rowsperpage);
        if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage'])) {
            $currentpage = (int)$_GET['currentpage'];
        } else {
            $currentpage = 1;  // default page numbergetregister
        }
        if ($currentpage < 1) {
            $currentpage = 1;
        }
        $offset = ($currentpage - 1) * $rowsperpage;
        $s = "SELECT m.name as m_name, mt.type as m_type, cu.unload_qty, mr.load_qty, u.unit, v.vehicle_no, mr.estimate_deliver_time, cu.unloaded_time, mr.loaded_time FROM manager_request mr, client_unload cu, vehicle v, material m, material_type mt, unit u WHERE mr.vehicle_id = cu.vehicle_id and cu.material_id = m.id and cu.material_type_id = mt.id and cu.vehicle_id = v.id and cu.unit_id = u.id ORDER BY cu.unloaded_time DESC LIMIT $offset,$rowsperpage";
        $posts = DB::select($s);
        if (count($posts) > 0) {
            return $this->sendResponse($posts, 'Material Compare List');
        } else {
            return $this->sendError('No record available', '');
        }
    }


    /**************Vehicle**********************/
    public function create_vehicle(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vehicle_no' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $vehicle = Vehicle::where(['vehicle_no' => request('vehicle_no')])->first();
        if (isset($vehicle)) {
            return $this->sendResponse([], 'Vehicle no already exist');
        } else {
            $material = new Vehicle();
            $material->vehicle_no = request('vehicle_no');
            $material->save();
            return $this->sendResponse($material, 'Vehicle no has been saved');
        }


    }

    public function getallvehicle()
    {
        $client_requests = Vehicle::where(['is_active' => 1])->get();
        if (count($client_requests) > 0) {
            return $this->sendResponse($client_requests, 'Vehicle List');
        } else {
            return $this->sendError('No record available', '');
        }
    }


    public function getvehicle(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vehicle_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Vehicle::find(request('vehicle_id'));
        if (isset($material) > 0) {
            return $this->sendResponse($material, 'Vehicle Record');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public function updatevehicle(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vehicle_id' => 'required',
            'vehicle_no' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Vehicle::find(request('vehicle_id'));
        $vehicle = Vehicle::where('vehicle_no', request('vehicle_no'), 'id', '!=', $material->id)->first();
        if (isset($vehicle)) {
            return $this->sendResponse([], 'Vehicle no already exist');
        } else {
            if (isset($material) > 0) {
                $material->vehicle_no = request('vehicle_no');
                $material->save();
                return $this->sendResponse($material, 'Vehicle no has been updated');
            } else {
                return $this->sendError('No record available', '');
            }
        }
    }

    public
    function deletevehicle(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vehicle_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = Vehicle::find(request('vehicle_id'));
        if (isset($material) > 0) {
            $material->is_active = 0;
            $material->save();
            return $this->sendResponse($material, 'Vehicle has been deleted');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    /**************Vehicle**********************/


    /**************petrol**********************/
    public
    function create_petrol(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'vehicle_id' => 'required',
            'qty' => 'required',
            'unit_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = new PetrolOrder();
        $material->vehicle_id = request('vehicle_id');
        $material->qty = request('qty');
        $material->unit_id = request('unit_id');
        $material->order_by = request('user_id');
        $material->save();
        return $this->sendResponse($material, 'Fuel request has been saved');
    }

    public
    function update_petrol_done(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = request('user_id');
        $material = PetrolOrder::find(request('order_id'));
        if (isset($material) > 0) {
            $material->is_done = 1;
            $material->done_by = $user_id;
            $material->save();
            return $this->sendResponse($material, 'Fuel request has been filled');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public
    function getallpetrol()
    {
        $petrols = DB::select("SELECT po.id, (select v.vehicle_no from vehicle v where v.id = po.vehicle_id) as vehicle_no, po.qty, (select un.unit from unit un where un.id = po.unit_id) as unit, (select u.name from users u where u.id = po.order_by) as staff, (select us.name from users us where us.id = po.done_by) as supervisor, po.created_time, po.is_active, po.is_done, po.order_by as staff_id FROM petrol_order po WHERE po.is_active = 1 order by po.id desc");
        if (count($petrols) > 0) {
            return $this->sendResponse($petrols, 'Fuel Order List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public
    function getallpetrolbyuser(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user_id = request('user_id');
        $petrols = DB::select("SELECT po.id, (select v.vehicle_no from vehicle v where v.id = po.vehicle_id) as vehicle_no, po.qty, (select un.unit from unit un where un.id = po.unit_id) as unit, (select u.name from users u where u.id = po.order_by) as staff, (select us.name from users us where us.id = po.done_by) as supervisor, po.created_time, po.is_active, po.is_done FROM petrol_order po WHERE po.is_active = 1 and po.order_by = $user_id order by po.id desc");
        if (count($petrols) > 0) {
            return $this->sendResponse($petrols, 'Fuel Order List');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public
    function getpetrol(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $order_id = request('order_id');
        $material = DB::select("SELECT po.id, (select v.vehicle_no from vehicle v where v.id = po.vehicle_id) as vehicle_no, po.qty, (select un.unit from unit un where un.id = po.unit_id) as unit, (select u.name from users u where u.id = po.order_by) as staff, (select us.name from users us where us.id = po.done_by) as supervisor, po.created_time, po.is_active, po.is_done FROM petrol_order po WHERE po.id = $order_id");
        if (isset($material) > 0) {
            return $this->sendResponse($material, 'Fuel Request Record');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public
    function updatepetrol(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
            'vehicle_id' => 'required',
            'qty' => 'required',
            'unit_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = PetrolOrder::find(request('order_id'));
        if (isset($material) > 0) {
            $material->vehicle_id = request('vehicle_id');
            $material->qty = request('qty');
            $material->unit_id = request('unit_id');
            $material->order_by = request('user_id');
            $material->save();
            return $this->sendResponse($material, 'Fuel request has been updated');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    public
    function deletepetrol(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $material = PetrolOrder::find(request('order_id'));
        if (isset($material) > 0) {
            $material->is_active = 0;
            $material->save();
            return $this->sendResponse($material, 'Fuel request has been deleted');
        } else {
            return $this->sendError('No record available', '');
        }
    }

    /**************petrol**********************/
    /****************************************Admin*******************************/

}
