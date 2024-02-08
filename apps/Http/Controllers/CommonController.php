<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

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
}
