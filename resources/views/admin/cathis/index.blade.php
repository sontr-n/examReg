@extends('adminlte::page')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<h1>Danh sách ca thi:</h1>
<a href="/admin/cathis/create" class="btn btn-primary">Tạo ca thi</a>
<hr>

<table id="category-table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Ca thi</th>
            <th>Phòng thi</th>
            <th>Số máy tính</th>
            <th>Môn học</th>
            <th>Mã môn</th>
            <th>Ngày thi</th>
            <th>Giờ bắt đầu</th>
            <th>Giờ kết thúc</th>
            <th>Người tạo</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cathis as $cathi)
            <tr>
                <td>{{ $cathi->name }}</td>
                <td>{{ $cathi->room }}</td>
                <td>{{ $cathi->quantityPC }}</td>
                @if ($cathi->monthis->count() > 0)
                    <td>
                        @foreach ($cathi->monthis as $monthi)                   
                            {{ $monthi->name }}
                            <br>
                        @endforeach
                    </td>
                    <td>{{ $monthi->subjectid }}</td>
                @else
                    <td></td>
                    <td></td>
                @endif
                <td>{{ $cathi->dayExam }}</td>
                <td>{{$cathi->startTime}}</td>
                <td>{{$cathi->endTime}}</td>
                <td>{{ $cathi->user->name }}</td>
                <td>
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.cathis.edit', $cathi->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                        </div>

                        <div class="col-md-3">
                            <form action="{{ route('admin.cathis.destroy', $cathi->id) }}" method="POST">
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
