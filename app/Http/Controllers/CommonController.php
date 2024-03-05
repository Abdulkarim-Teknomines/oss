<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Mediclaim;
use App\Models\Lifeinsurance;
use App\Models\VehicleInsurance;

class CommonController extends Controller
{
    public function fetchState(Request $request)
    {
        // dd($request->all());

        $data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        // dd($data['states']);
        return response()->json($data);
    }
    public function fetchCity(Request $request)
    {
        $data['cities'] = City::where("state_id", $request->state_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function fetchPolicyUser(Request $request)
    {
        $data['policy_users'] = Mediclaim::with('user')->where("policy_number", $request->policy_number)->get();
        return response()->json($data);
    }
    public function fetchLifeInsurancePolicy(Request $request)
    {
        $data['policy_users'] = Lifeinsurance::with('user')->where("policy_number", $request->policy_number)->get();
        return response()->json($data);
    }
    public function fetchVehicleInsurancePolicy(Request $request)
    {
        
        $data['policy_users'] = VehicleInsurance::with('user')->where("policy_number", $request->policy_number)->get();
        return response()->json($data);
    }
    public function fetchPolicyUsers(Request $request)
    {
        $data['policy_users'] = Mediclaim::with('user')->where("policy_number", $request->policy_number)->where('id','!=',$request->mediclaim_id)->get();
        return response()->json($data);
    }
    public function fetchLifeInsurancePolicys(Request $request)
    {
        $data['policy_users'] = Lifeinsurance::with('user')->where("policy_number", $request->policy_number)->where('id','!=',$request->life_insurance_id)->get();
        return response()->json($data);
    }
    public function fetchVehicleInsurancePolicys(Request $request)
    {
        
        $data['policy_users'] = VehicleInsurance::with('user')->where("policy_number", $request->policy_number)->where('id','!=',$request->vehicle_insurance_id)->get();
        return response()->json($data);
    }
}
