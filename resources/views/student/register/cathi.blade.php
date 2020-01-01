@extends('adminlte::page')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<h1>Danh sách ca thi</h1>
<hr>
<form action="{{route('student.schedule.submit')}}" method="POST">
@csrf
<table id="category-table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Ca thi</th>
            <th>Tên phòng</th>
            <th>Số lượng</th>
            <th>Ngày thi</th>
            <th>Giờ bắt đầu</th>
            <th>Giờ kết thúc</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cathis as $cathi)
            <tr>
                @if ($registedCathi != null && $registedCathi->cathi_id == $cathi->id)
                    <td><input type="radio" name="cathiId" value='{{$cathi->id}}' checked></td>
                @elseif ($cathi->quantityPC > 0)
                    <td><input type="radio" name="cathiId" value='{{$cathi->id}}'></td>
                @else
                    <td><input type="radio" name="cathiId" value='{{$cathi->id}}' disabled></td>
                @endif 
                <td>{{ $cathi->name }}</td>
                <td>{{ $cathi->room }}</td>
                <td>{{ $cathi->quantityPC }}</td>
                <td>{{ $cathi->dayExam }}</td>
                <td>{{ $cathi->startTime }}</td>
                <td>{{ $cathi->endTime }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<input type="submit" class="btn btn-primary" value="Lưu đăng ký">
</form>

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
