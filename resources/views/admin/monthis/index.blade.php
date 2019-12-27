@extends('adminlte::page')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<h1>Danh sách môn thi:</h1>
<a href="/admin/monthis/create" class="btn btn-primary">Tạo môn thi</a>
<hr>

<table id="category-table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Tên môn</th>
            <th>Mã môn</th>
            <th>Người tạo</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($monthis as $monthi)
            <tr>
                <td>{{ $monthi->name }}</td>
                <td>{{ $monthi->subjectid }}</td>
                <td>{{ $monthi->user->name }}</td>
                
                <td>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.monthis.edit', $monthi->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                        </div>

                        <div class="col-md-3">
                            <form action="{{ route('admin.monthis.destroy', $monthi->id) }}" method="POST">
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
