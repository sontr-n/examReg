<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $svs = DB::table('users')
                ->join('students', 'users.id', '=', 'students.userid')
                ->where('roles', 'student')
                ->get();
        return view('admin.sinhvien.index', compact('svs'));
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
            Student::create($data);

        } catch (\Exception $e) {
            \Log::error($e);
            
            return back()->withInput($data)->with('status', 'Tạo sinh viên lỗi');
        }
        
        return redirect('/admin/sinhvien/')
            ->with('status', 'Tạo sinh viên thành công!');
    }
}
