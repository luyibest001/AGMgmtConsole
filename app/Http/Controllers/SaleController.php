<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /*
     * list all sales
     * */
    public function list(){

    }

    /*
     * get sales with day totals between two date
     *
     * */
    public function getDayTotalsByDateRange(Request $request){
        $sales = Sale::select('date', \DB::raw('SUM(price) as total'))
                     ->join('products', 'product_id','=','products.id')
                     ->groupBy('date')
                     ->orderBy('date')
                     ->get();
        return $sales;
    }
}
