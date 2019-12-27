<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use App\User;

use Illuminate\Http\Request;

class SinhvienController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'student');
        $ids = $users->pluck('id')->toArray();
        $svs = Student::find($ids);
        return view('admin.sinhvien.index', compact(['svs']));
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
            $data['role'] = 'student';
            $data['password'] = Hash::make($data['studentId']);
            $user = User::create($data);
            $data['userid'] = $user->id; 
            Student::create($data);

        } catch (\Exception $e) {
            \Log::error($e);
            
            return back()->withInput($data)->with('status', 'Tạo sinh viên lỗi');
        }
        
        return redirect('/admin/sinhvien/')
            ->with('status', 'Tạo sinh viên thành công!');
    }
}
