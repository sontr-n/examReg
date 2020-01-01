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


    public function edit($id) {
        $student = DB::table('students')
                    ->join('users', 'users.id', '=', 'students.userId')
                    ->where('users.id', $id)
                    ->first();
        return view('admin.sinhvien.edit', compact('student'));
    }


    public function create()
    {
        return view('admin.sinhvien.create');
    }


    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'dob',
            'class',
            'studentId',
            'email',
        ]);

        try {
            $data['roles'] = 'student';
            $data['password'] = Hash::make($data['studentId']);
            $user = User::create($data);
            $data['userId'] = $user->id;
            $st = DB::table('students')
            ->where('studentId', $data['studentId'])
            ->get(); 
            //check if existed a student has a same stduentId  
            if (count($st) > 0)
                return back()->withInput($data)->with('status', 'Tồn tại mã sinh viên');             
            Student::create($data);

        } catch (\Exception $e) {
            \Log::error($e);   
            return back()->withInput($data)->with('status', 'Tạo sinh viên lỗi');
        }
        
        return redirect('/admin/sinhvien/')
            ->with('status', 'Tạo sinh viên thành công!');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $student = Student::where('userId', $user->id);
        try {
            $student->delete();
            $user->delete();
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->with('status', 'Xóa thất bại');
        }

        return redirect('admin/sinhvien')->with('status', 'Xoá thành công');
    }
}
