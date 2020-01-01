@extends('adminlte::page')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<h1>Danh sách Sinh viên: </h1>
<a href="/admin/sinhvien/create" class="btn btn-primary">Thêm sinh viên</a>
<hr>

<table id="category-table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Tên Sinh viên</th>
            <th>Mã Sinh viên</th>
            <th>Lớp</th>
            <th>Ngày sinh</th>
            <th>Email</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $s)
            <tr>
                <td>{{$s->name}}</td>
                <td>{{$s->studentId}}</td>
                <td>{{$s->class}}</td>
                <td>{{$s->dob}}</td>
                <td>{{$s->email}}</td>
                <td>
                    <div class="operate">
                        <div>
                            <a href="{{ route('admin.sinhvien.edit', $s->userid) }}" class="btn btn-sm btn-primary">Sửa</a>
                        </div>
                        <div>
                            <form action="{{ route('admin.sinhvien.destroy', $s->userid) }}" method="POST">
                                @csrf
                                @method('DELETE')
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
