<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Monthi;
use App\Models\MonthiSinhvien;
use App\Models\Cathi;
use App\Models\Student;
use App\Imports\SubjectStudentImport;
use Excel; 

class MonthiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $monthis = Monthi::orderBy('created_at', 'desc')->get();

        return view('admin.monthis.index', ['monthis' => $monthis]);
    }
    
    public function listStudentIndex($monthiId) {
        $registedStudents = DB::table('sinhvien_monthi')
                ->join('students', 'students.studentId', '=', 'sinhvien_monthi.studentId')
                ->join('users', 'students.userId', '=', 'users.id')
                ->where('monthiId', $monthiId)
                ->get();
        return view('admin.monthis.dssv', compact('registedStudents', 'monthiId'));
    }

    public function getAddStudent($monthiId) {
        $students = DB::table('users')
        ->join('students', 'users.id', '=', 'students.userid')
        ->join('sinhvien_monthi', 'sinhvien_monthi.studentId', '=', 'students.id')
        ->join('monthis', 'monthis.id', '=', 'sinhvien_monthi.monthiId')
        ->where('monthiId', 'NULL')
        ->where('roles', 'student')
        ->get();
        return view('admin.monthis.addStudent', compact('students', 'monthiId'));
    }

    public function postAddStudent(Request $request, $monthiId) {
        $data = $request->only([
            'studentId',
            'eligible',
        ]);
        $data['monthiId'] = $monthiId;
        try {
            $tbl = DB::table('sinhvien_monthi')
                ->where('studentId', $data['studentId'])
                ->where('monthiId', $monthiId)
                ->get();
            if (count($tbl) > 0)
                return back()->withInput($data)->with('status', 'Sinh viên đẫ có trong danh sách');
            
            $tbl = DB::table('students')
                ->where('studentId', $data['studentId'])  
                ->get();
            if (count($tbl) == 0)
                return back()->withInput($data)->with('status', 'không tồn tại sinh viên');

            MonthiSinhvien::create($data);
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->withInput($data)->with('status', 'Thêm sinh viên lỗi');
        }
        
        return redirect()->route('admin.monthis.dssv', $monthiId) 
                        ->with('status', 'Thêm sinh viên thành công!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $monthis = Monthi::all();

        return view('admin.monthis.create', compact('monthis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\monthiRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->only([
            'name',
            'subjectid',
        ]);

        $data['user_id'] = auth()->id();
        try {

            $monthi = Monthi::create($data);
            
        } catch (\Exception $e) {
            \Log::error($e);
            
            return back()->withInput($data)->with('status', 'Tạo môn thi lỗi');
        }
        
        return redirect('/admin/monthis/')
            ->with('status', 'Tạo môn thi thành công!');
    }

    public function uploadStudentList(Request $request) {
        try {
            //get path
            $path = $request->file('file')->getRealPath();
            Excel::import(new SubjectStudentImport, $path);
        } catch (\Exception $e) {
            \Log::error($e);   
            return back()->with('status-err', 'Upload file thất bại');
        }
        return back()->with('status-success', 'Upload file thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $monthi = Monthi::findOrFail($id);
        $monthis = Monthi::all();
        $data = [
            'monthis' => $monthis,
            'monthi' => $monthi,
        ];

        return view('admin.monthis.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->only([
            'name',
            'subjectid',
        ]);

        $monthi = Monthi::findOrFail($id);

        try {
            $monthi->update($data);
        } catch (\Exception $e) {
            \Log::error($e);

            return back()->with('status', 'Cập nhập thất bại');
        }

        return redirect('admin/monthis')->with('status', 'Cập nhập thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $monthi = Monthi::findOrFail($id);

        try {
            $monthi->delete();
        } catch (\Exception $e) {
            \Log::error($e);

            return back()->with('status', 'Delete faild.');
        }

        return redirect('admin/monthis')->with('status', 'Xoá thành công');
    }

    public function deleteStudent($monthiId, $userId) {
        $registedStudents = DB::table('sinhvien_monthi')
                ->join('students', 'students.studentId', '=', 'sinhvien_monthi.studentId')
                ->join('users', 'students.userId', '=', 'users.id')
                ->where('monthiId', $monthiId)
                ->get();
        $student = DB::table('students')
                ->join('users', 'users.id', '=', 'students.userId')
                ->where('users.id', $userId)    
                ->first();
        $mt_sv = MonthiSinhvien::where('studentId', $student->studentId)
                ->where('monthiId', $monthiId)
                ->firstOrFail();
        try {
            $mt_sv->delete();
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->with('status', 'Xóa thất bại.');
        }
        return redirect()->route('admin.monthis.dssv', compact('monthiId', 'registedStudents'))->with('status', 'Xoá thành công');
    }
}
