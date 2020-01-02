<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Student;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class StudentsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows) {
        foreach ($rows as $row) {
            $data = array(
                'name'  => $row[0],
                'studentId' => $row[1],
                'class' => $row[2],
                'dob'   => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])->format('Y-m-d'),
                'email' => $row[4],
            );
            $data['password'] = Hash::make($data['studentId']);
            $data['roles'] = 'student';
            try {
                if ($data['name'] != null) {
                    $user = User::create($data);
                    $data['userId'] = $user->id;
                    Student::create($data);
                }

            } catch (\Exception $e) {
                dd($e);
            }
        }
    }
}
