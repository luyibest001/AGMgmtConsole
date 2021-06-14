<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $employees = Employee::orderBy('name','asc')->get();

        return response()->json(['employees'=>$employees], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByName(Request $request){
        $keyword = $request->keyword;

        $employees = Employee::where('name','like', '%' . $$keyword . '%')->get();
        return response()->json(['employees'=>$employees], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByID(Request $request){
        $id = $request->id;

        if(!empty($id)){
            $employees = Employee::where('id', $id)->get();
            return response()->json(['employees'=>$employees], 200);
        }

        return response()->json(['message'=>'invalid parameters'], 404);
    }
}
