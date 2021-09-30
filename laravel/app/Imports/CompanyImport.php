<?php

namespace App\Imports;

use Illuminate\Support\Collection;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CompanyImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Company([
            'name' => $row['name'],
            'email' => $row['email'],
            'website' => $row['website']
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
