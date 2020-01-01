<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;


use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function getInfo()
    {
        $id = auth()->id();
        $student = DB::table('users')
                ->join('students', 'users.id', '=', 'students.userid')
                ->where('roles', 'student')
                ->where('users.id', $id)
                ->first();
        return view('student.info.index', compact('student'));
    }

    public function update(Request $request) {
        $data = $request->only([
            'dob',
            'email',
        ]);
        $id = auth()->id();
        $student = DB::table('students')
                    ->join('users', 'users.id', '=', 'students.userId')
                    ->where('users.id', $id)
                    ->first();
        $user = User::find($id);
        $st = Student::where('studentId', $student->studentId)->first();
        try {
            $user->update($data);
            $st->update($data);
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->with('status-err', 'Cập nhập lỗi');
        }

        return redirect()->route('student.getInfo')->with('status-success', 'Cập nhập thành công');
    }

}
