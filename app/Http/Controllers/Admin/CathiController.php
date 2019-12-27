<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cathi;
use App\Models\Monthi;
use App\Models\CathiMonthi;

class CathiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cathis = Cathi::all();
        
        return view('admin.cathis.index', ['cathis' => $cathis]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $monthis = Monthi::all();

        return view('admin.cathis.create', compact('monthis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'quantityPC',
            'dayExam',
            'room',
            'subjectid',
            'startTime',
            'endTime'
        ]);

        $data['user_id'] = auth()->id();
        if ($data['subjectid'] == 0) {
            return back()->withInput($data)->with('status', 'Tạo ca thi lỗi');
        }

        try {
            $cathi = Cathi::create($data);
            $data['cathi_id'] = $cathi->id;
            $data['monthi_id'] = $data['subjectid'];
            CathiMonthi::create($data);
            
        } catch (\Exception $e) {
            \Log::error($e);

            return back()->withInput($data)->with('status', 'Tạo ca thi lỗi');
        }

        return redirect('/admin/cathis')
            ->with('status', 'Tạo ca thi thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cathi = Cathi::findOrFail($id);

        $data = ['cathi' => $cathi];

        return view('admin.cathis.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cathi = Cathi::findOrFail($id);
        // $categories = Category::all();
        $data = [
            'cathi' => $cathi,
            // 'categories' => $categories,
        ];

        return view('admin.cathis.edit', $data);
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
            'quantityPC',
            'dayExam',
            'room',
            'startTime',
            'endTime',
        ]);

        $cathi = Cathi::findOrFail($id);

        try {
            $cathi->update($data);
        } catch (\Exception $e) {
            \Log::error($e);

            return back()->with('status', 'Cập nhập lỗi');
        }

        return redirect('admin/cathis/')->with('status', 'Cập nhập thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cathi = Cathi::findOrFail($id);

        try {
            $cathi->delete();
        } catch (\Exception $e) {
            \Log::error($e);

            return back()->with('status', 'Delete faild.');
        }

        return redirect('admin/cathis')->with('status', 'Xoá thành công');
    }
}
