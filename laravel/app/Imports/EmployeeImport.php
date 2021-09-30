<?php

namespace App\Imports;

use Illuminate\Support\Collection;

use App\Models\Employee;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        $companyId = Company::where('name', 'LIKE', '%' . $row['company'] . '%')->first()->id;

        return new Employee([
            'name' => $row['name'],
            'company_id' => $companyId,
            'company' => $row['company'],
            'email' => $row['email']
        ]);
    }

    public function chunkSize(): int
    {
        return 10;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
