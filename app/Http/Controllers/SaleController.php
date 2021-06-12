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
        $sales = Sale::select('sales.date','SUM(products.price)')
                     ->join('products', 'sales.product_id','=','products.id')
                     ->groupBy('sales.date')
                     ->orderBy('sales.date')
                     ->get();
        return $sales;
    }
}
