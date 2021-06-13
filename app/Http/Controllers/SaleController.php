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

    public function getLastMonth(){
        $sale = Sale::select('date', \DB::raw('SUM(price) as total'))
            ->join('products', 'product_id','=','products.id')
            ->groupBy('date')
            ->orderBy('date','desc')
            ->first();
        $latestDate = strtotime($sale->date);
        \Log::info($sale->date);
        $firstDayOfTheMonth = date('Y-m-01', $latestDate);
        $lastDayOfTheMonth = date('Y-m-t', $latestDate);
        \Log::info($firstDayOfTheMonth);
        \Log::info($lastDayOfTheMonth);
        $sales = Sale::select('date', \DB::raw('SUM(price) as total'))
                    ->join('products', 'product_id','=','products.id')
                    ->whereBetween('date', [$firstDayOfTheMonth,$lastDayOfTheMonth])
                    ->groupBy('date')
                    ->orderBy('date','asc')
                    ->get();

        return response()->json(["sales"=>$sales], 200);
    }

    /*
     * get sales with day totals between two date
     *
     * */
    public function getDayTotalsByDateRange(Request $request){
        $start = $request->start;
        $end = $request->end;

        if(empty($start) || empty($end)){
            return response()->json(["message"=>"invalid parameters."], 400);
        }

        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        \Log::info($start);
        \Log::info($end);

        $sales = Sale::select('date', \DB::raw('SUM(price) as total'))
                     ->join('products', 'product_id','=','products.id')
                     ->whereBetween('date', [$start, $end])
                     ->groupBy('date')
                     ->orderBy('date')
                     ->get();
        return response()->json(["sales"=>$sales], 200);
    }
}
