@extends('adminlte::page')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<h1>Danh sách môn thi</h1>
<hr>
<table id="category-table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Tên môn</th>
            <th>Mã môn</th>
            <th>Tình trạng</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($monthis as $monthi)
            <tr>
                <td>{{ $monthi->name }}</td>
                <td>{{ $monthi->subjectid }}</td>
                @if ($monthi->eligible)
                <td><p style="color: #00c728">Đủ điều kiện<p></td>
                @else 
                <td><p style="color: #FF4500">Không đủ điều kiện<p></td>
                @endif 
                <td>
                    <div class="operate">
                        <div>
                            @if ($monthi->eligible)
                            <a href="{{ route('student.schedule.monthi', $monthi->id) }}" class="btn btn-sm btn-primary">Đăng ký</a>
                            @endif
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
