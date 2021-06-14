<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /*
     * list all sales
     * */
    public function list(Request $request){
        /*$user = \Auth::user();
        \Log::info($user);
        if(isset($user)){*/
        $customer = $request->customer;
        $product = $request->product;
        $employee = $request->employee;
        if(!empty($customer) || !empty($product) || !empty($employee)){
            if(!empty($customer) && empty($product) && empty($employee)){
                $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                    ->join('products', 'products.id','=','sales.product_id')
                    ->join('employees', 'sales_person_id', '=', 'employees.id')
                    ->join('customers', 'customer_id', '=', 'customers.id')
                    ->where('customer_id', $customer)
                    ->orderBy('date', 'desc')
                    ->get();
            }else if(!empty($customer) && !empty($product) && empty($employee)){
                $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                    ->join('products', 'products.id','=','sales.product_id')
                    ->join('employees', 'sales_person_id', '=', 'employees.id')
                    ->join('customers', 'customer_id', '=', 'customers.id')
                    ->where('customer_id', $customer)
                    ->where('product_id',$product)
                    ->orderBy('date', 'desc')
                    ->get();
            }else if(!empty($customer) && !empty($product) && !empty($employee)){
                $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                    ->join('products', 'products.id','=','sales.product_id')
                    ->join('employees', 'sales_person_id', '=', 'employees.id')
                    ->join('customers', 'customer_id', '=', 'customers.id')
                    ->where('customer_id', $customer)
                    ->where('product_id',$product)
                    ->where('sales_person_id', $employee)
                    ->orderBy('date', 'desc')
                    ->get();
            }else if(empty($customer) && !empty($product) && !empty($employee)){
                $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                    ->join('products', 'products.id','=','sales.product_id')
                    ->join('employees', 'sales_person_id', '=', 'employees.id')
                    ->join('customers', 'customer_id', '=', 'customers.id')
                    ->where('product_id',$product)
                    ->where('sales_person_id', $employee)
                    ->orderBy('date', 'desc')
                    ->get();
            }else if(!empty($customer) && empty($product) && !empty($employee)){
                $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                    ->join('products', 'products.id','=','sales.product_id')
                    ->join('employees', 'sales_person_id', '=', 'employees.id')
                    ->join('customers', 'customer_id', '=', 'customers.id')
                    ->where('sales_person_id', $employee)
                    ->where('customer_id', $customer)
                    ->orderBy('date', 'desc')
                    ->get();
            }else if(empty($customer) && empty($product) && !empty($employee)){
                $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                    ->join('products', 'products.id','=','sales.product_id')
                    ->join('employees', 'sales_person_id', '=', 'employees.id')
                    ->join('customers', 'customer_id', '=', 'customers.id')
                    ->where('sales_person_id', $employee)
                    ->orderBy('date', 'desc')
                    ->get();
            }else if(empty($customer) && !empty($product) && empty($employee)){
                $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                    ->join('products', 'products.id','=','sales.product_id')
                    ->join('employees', 'sales_person_id', '=', 'employees.id')
                    ->join('customers', 'customer_id', '=', 'customers.id')
                    ->where('product_id', $product)
                    ->orderBy('date', 'desc')
                    ->get();
            }

        }else{
            $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                ->join('products', 'products.id','=','sales.product_id')
                ->join('employees', 'sales_person_id', '=', 'employees.id')
                ->join('customers', 'customer_id', '=', 'customers.id')
                ->orderBy('date', 'desc')
                ->get();
        }

        return response()->json(['sales'=>$sales], 200);
        /*}

        return response()->json(['message'=>'unauthenticated'], 403);*/
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByDateRange(Request $request){
        $start = $request->start;
        $end = $request->end;

        if(empty($start) && empty($end)){
            $sale = Sale::select('date', \DB::raw('SUM(price) as total'))
                ->join('products', 'product_id','=','products.id')
                ->groupBy('date')
                ->orderBy('date','desc')
                ->first();
            $latestDate = strtotime($sale->date);
            $firstDayOfTheMonth = date('Y-m-01', $latestDate);
            $lastDayOfTheMonth = date('Y-m-t', $latestDate);
            $salesTotal = Sale::select('date', \DB::raw('SUM(price) as total'))
                ->join('products', 'product_id','=','products.id')
                ->whereBetween('date', [$firstDayOfTheMonth,$lastDayOfTheMonth])
                ->groupBy('date')
                ->orderBy('date','asc')
                ->get();

            $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                ->join('products', 'products.id','=','sales.product_id')
                ->join('employees', 'sales_person_id', '=', 'employees.id')
                ->join('customers', 'customer_id', '=', 'customers.id')
                ->whereBetween('date', [$firstDayOfTheMonth, $lastDayOfTheMonth])
                ->orderBy('date', 'desc')
                ->get();

            return response()->json(["salesTotal"=>$salesTotal, 'sales'=>$sales], 200);
        }

        if(empty($start)){
            $salesTotal = Sale::select('date', \DB::raw('SUM(price) as total'))
                ->join('products', 'product_id','=','products.id')
                ->groupBy('date')
                ->where('date','<',$end)
                ->orderBy('date','desc')
                ->get();
            $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                ->join('products', 'products.id','=','sales.product_id')
                ->join('employees', 'sales_person_id', '=', 'employees.id')
                ->join('customers', 'customer_id', '=', 'customers.id')
                ->where('date', '<', $end)
                ->orderBy('date', 'desc')
                ->get();
            return response()->json(["salesTotal"=>$salesTotal, 'sales'=>$sales], 200);
        }

        if(empty($end)){
            $salesTotal = Sale::select('date', \DB::raw('SUM(price) as total'))
                ->join('products', 'product_id','=','products.id')
                ->groupBy('date')
                ->where('date','<',$end)
                ->orderBy('date','desc')
                ->get();

            $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
                ->join('products', 'products.id','=','sales.product_id')
                ->join('employees', 'sales_person_id', '=', 'employees.id')
                ->join('customers', 'customer_id', '=', 'customers.id')
                ->where('date', '<', $end)
                ->orderBy('date', 'desc')
                ->get();

            return response()->json(["salesTotal"=>$salesTotal, 'sales'=>$sales], 200);
        }

        $salesTotal = Sale::select('date', \DB::raw('SUM(price) as total'))
            ->join('products', 'product_id','=','products.id')
            ->groupBy('date')
            ->whereBetween('date', [$start,$end])
            ->orderBy('date','desc')
            ->get();

        $sales = Sale::select('invoiceId', 'products.name as product_name', 'product_id', 'products.price', 'employees.name as sales_person_name', 'sales_person_id', 'customers.full_name as customer_name', 'customer_id','date')
            ->join('products', 'products.id','=','sales.product_id')
            ->join('employees', 'sales_person_id', '=', 'employees.id')
            ->join('customers', 'customer_id', '=', 'customers.id')
            ->whereBetween('date', [$start,$end])
            ->orderBy('date', 'desc')
            ->get();

        return response()->json(["salesTotal"=>$salesTotal, 'sales'=>$sales], 200);

    }
}
