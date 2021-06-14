<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request){
        $products = Product::orderBy('name', 'asc')->get();

        return response()->json(['products'=>$products], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByName(Request $request){
        $keyword = $request->keyword;

        $products = Product::where('name','like', '%' . $$keyword . '%')->get();
        return response()->json(['products'=>$products], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByID(Request $request){
        $id = $request->id;

        if(!empty($id)){
            $products = Product::where('id', $id)->get();
            return response()->json(['products'=>$products], 200);
        }

        return response()->json(['message'=>'invalid parameters'], 404);
    }
}
