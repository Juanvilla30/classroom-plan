<?php

namespace App\Imports;

use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;

class FacultyImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $isFirstRow = true;
        foreach ($rows as $row) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue;
            }
            // dd($row);
            Faculty::create([
                'code_faculty' => $row[1],
                'name_faculty' => $row[2],
            ]);
        }
    }
}
