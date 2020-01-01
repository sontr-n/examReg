@extends('adminlte::page')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<h1>Danh sách đăng ký: </h1>
<a href="{{route('admin.monthis.addStudent', $monthiId)}}" class="btn btn-primary">Thêm sinh viên</a>
<hr>
<table id="category-table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Tên Sinh viên</th>
            <th>Mã Sinh viên</th>
            <th>Lớp</th>
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
