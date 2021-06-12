<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sale::truncate();

        $inputFileName = "sales.xls";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $row = 2;
        while($row <= count($rows)){
            \Log::info($rows[$row - 1]);
            $sale = $rows[$row - 1];
            Sale::create([
                'invoiceId' => $sale[0],
                'product_id' => Product::where('name', $sale[1])->first()->id,
                'date' => date('Y-m-d', strtotime($sale[2])),
                'sales_person_id' => Employee::where('name', $sale[3])->first()->id,
                'customer_id' => Customer::where('full_name', $sale[4])->first()->id,

            ]);
            $row ++;
        }
    }
}
