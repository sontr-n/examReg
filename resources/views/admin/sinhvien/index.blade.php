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
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($svs as $sv)
            <tr>
               <td>{{$sv->name}}</td>
               <td>{{$sv->studentId}}</td>
               <td>{{$sv->class}}</td>
               <td>{{$sv->dob}}</td>
               <td></td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#category-table').DataTable({
                "order": [[ 5, "desc" ]]
            });
        } );
    </script>
@stop
