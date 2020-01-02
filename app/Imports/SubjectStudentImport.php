<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\MonthiSinhvien;
use App\Models\Monthi;


class SubjectStudentImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $data = array(
                'studentId'  => $row[0],
                'monthiId' => $row[1],
                'eligible' => $row[2],
            );
            try {
                if ($data['studentId'] != null) {
                    $rw = Monthi::where('subjectId', $data['monthiId'])->first();
                    $data['monthiId'] = $rw->id;
                    MonthiSinhvien::create($data);
                }

            } catch (\Exception $e) {
                dd($e);
            }
        }
    }
}
