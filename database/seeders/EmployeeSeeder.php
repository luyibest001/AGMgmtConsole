<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::truncate();

        $inputFileName = "employees.xls";
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $row = 2;
        while($row <= count($rows)){
            \Log::info($rows[$row - 1]);
            $employee = $rows[$row - 1];
            Employee::create([
                'name' => $employee[1],
            ]);
            $row ++;
        }
    }
}
