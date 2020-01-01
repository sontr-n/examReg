<?php

namespace App\Http\Controllers\Student;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Cathi;
use App\Models\Schedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;


use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index() {
        $id = auth()->id();
        $student = Student::where('userId', $id)->first();
        $monthis = DB::table('sinhvien_monthi')
                ->join('monthis', 'sinhvien_monthi.monthiId', '=', 'monthis.id')
                ->where('sinhvien_monthi.studentId', $student->studentId)
                ->get();
        return view('student.register.index', compact('monthis'));
    }

    public function getCathi($monthiId) {
        //query cathis of monthiID
        $cathis = DB::table('cathi_monthi')
                ->join('cathis', 'cathis.id', '=', 'cathi_monthi.cathi_id')
                ->where('cathi_monthi.monthi_id', $monthiId)
                ->get();
        //query registed cathi of 
        $registedCathi = DB::table('schedules')
                ->join('cathi_monthi', 'cathi_monthi.id', '=', 'schedules.id')
                ->join('monthis', 'monthis.id', '=', 'cathi_monthi.monthi_id')
                ->where('monthis.id', $monthiId)
                ->first();
        return view('student.register.cathi', compact('cathis', 'registedCathi'));
    }

    public function postCathi(Request $request) {
        $data = $request->only(['cathiId']);
        //get student id
        $id = auth()->id();
        $student = Student::where('userId', $id)->first();
        //check if cathi has been scheduled
        $existedSchedule = Schedule::where('cathiId', $data['cathiId'])
                            ->where('studentId', $student->studentId)
                            ->first();
        if ($existedSchedule != null)
            return redirect()->route('student.schedule.index')->with('status', 'Lưu thành công');
        //add student id into data array
        $data['studentId'] = $student->studentId;
        //save schedule to DB
        Schedule::create($data);
        //subtract quantity PC in registed ca_thi
        $cathi = Cathi::findOrFail($data['cathiId']);
        $data['quantityPC'] = $cathi->quantityPC;
        $data['quantityPC'] -= 1;
        try {
            $cathi->update($data);
        } catch (\Exception $e) {
            \Log::error($e);
            return back()->with('status', 'Lưu thất bại');
        }

        return redirect()->route('student.schedule.index')->with('status', 'Lưu thành công');


    }

}
