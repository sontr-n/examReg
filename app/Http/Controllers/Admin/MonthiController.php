<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Monthi;
use App\Models\CathiMonthi;
use App\Models\Cathi;


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
}
