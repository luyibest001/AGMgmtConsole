<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::truncate();

        $inputFileName = "customers.xls";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $row = 2;
        while($row <= count($rows)){
            \Log::info($rows[$row - 1]);
            $customer = $rows[$row - 1];
            Customer::create([
                'first_name' => $customer[1],
                'last_name' => $customer[2],
                'full_name' => $customer[3],
                'email' => $customer[4],
                'gender' => $customer[5],
                'street' => $customer[6],
                'city' => $customer[7]
            ]);
            $row ++;
        }

    }
}
