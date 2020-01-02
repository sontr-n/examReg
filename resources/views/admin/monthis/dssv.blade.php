@extends('adminlte::page')

@section('content')


@if (session('status-success'))
    <div class="alert alert-success">
        {{ session('status-success') }}
    </div>
@endif
@if (session('status-err'))
    <div class="alert alert-error">
        {{ session('status-err') }}
    </div>
@endif


<h1>Danh sách đăng ký </h1>
<div style="display: flex">
    <div>
        <a href="{{route('admin.monthis.addStudent', $monthiId)}}" style='margin-right: 700px' class="btn btn-primary">Thêm sinh viên</a>
    </div>
    <div>
    <form action="{{route('admin.monthi.upload')}}" method="post" enctype="multipart/form-data">
    @csrf
        <input type="file" name="file" style='display:inline' accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
        <button type="submit" class="btn btn-info">Upload file</button>
    </form>
    </div>
</div>
<hr>
<table id="category-table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Tên Sinh viên</th>
            <th>Mã Sinh viên</th>
            <th>Lớp</th>
            <th>Email</th>
            <th>Tình trạng</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($registedStudents as $s)
            <tr>
                <td>{{$s->name}}</td>
                <td>{{$s->studentId}}</td>
                <td>{{$s->class}}</td>
                <td>{{$s->email}}</td>
                @if ($s->eligible)
                <td><p style="color: #00c728">Đủ điều kiện<p></td>
                @else 
                <td><p style="color: #FF4500">Không đủ điều kiện<p></td>
                @endif 
                <td>
                <div class="operate">
                    <div>
                        <a href="{{ route('admin.monthis.getEditStudent', [$monthiId, $s->id]) }}" class="btn btn-sm btn-primary">Sửa</a>
                    </div>
                    <div>
                        <form action="{{ route('admin.monthis.deleteStudent', [$monthiId, $s->id]) }}" method="POST">
                            @csrf
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        {{ __('Xoá') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('css')
<style>
    .operate {
        display: inline-flex;
    }

    .operate > div {
        padding-right: 5px;
    }

</style>
@stop
@section('js')
@stop
