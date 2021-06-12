<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        $inputFileName = "products.xls";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $row = 2;
        while($row <= count($rows)){
            \Log::info($rows[$row - 1]);
            $product = $rows[$row - 1];
            Product::create([
                'name' => $product[1],
                'price' => $product[2]
            ]);
            $row ++;
        }
    }
}
