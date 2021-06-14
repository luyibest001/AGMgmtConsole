<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $customers = Customer::orderBy('full_name', 'asc')->get();

        return response()->json(['customers'=>$customers], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByName(Request $request){
        $keyword = $request->keyword;

        $customers = Customer::where('name','like', '%' . $$keyword . '%')->get();
        return response()->json(['customers'=>$customers], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByID(Request $request){
        $id = $request->id;

        if(!empty($id)){
            $customers = Customer::where('id', $id)->get();
            return response()->json(['customers'=>$customers], 200);
        }

        return response()->json(['message'=>'invalid parameters'], 404);
    }
}
