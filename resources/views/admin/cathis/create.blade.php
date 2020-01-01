@extends('adminlte::page')

@section('content')

<div class="container">
    @if (session('status'))
        <div class="alert alert-danger">
            {{ session('status') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tạo ca thi') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cathis.store') }}">
                        @csrf

                    <div class="form-group row">
                            <label for="subjectid" class="col-md-4 col-form-label text-md-right">{{ __('Môn thi') }}</label>

                            <div class="col-md-6">
                                <select
                                    id="subjectid"
                                    class="form-control"
                                    @error('subjectid') is-invalid @enderror
                                    name="subjectid"
                                    value="{{ old('subjectid') }}"
                                >
                                    <option value="0">Chọn môn thi</option>

                                    @foreach ($monthis as $monthi)
                                        <option value="{{ $monthi->id }}">
                                            {{ $monthi->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('subjectid')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên ca thi') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="room" class="col-md-4 col-form-label text-md-right">{{ __('Tên phòng') }}</label>

                            <div class="col-md-6">
                                <input id="room" type="text" min=1 class="form-control @error('room') is-invalid @enderror" name="room" required autocomplete="room">{{ old('room') }}</textarea>

                                @error('room')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantityPC" class="col-md-4 col-form-label text-md-right">{{ __('Số lượng máy tính') }}</label>

                            <div class="col-md-6">
                                <input id="quantityPC" type="number" min=1 class="form-control @error('quantityPC') is-invalid @enderror" name="quantityPC" value="{{ old('quantityPC') }}" required autocomplete="new-quantityPC">

                                @error('quantityPC')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dayExam" class="col-md-4 col-form-label text-md-right">{{ __('Ngày thi') }}</label>

                            <div class="col-md-6">
                                <input id="dayExam" type="date" class="form-control" name="dayExam" value="{{ old('dayExam') }}" required autocomplete="new-dayExam">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dayExam" class="col-md-4 col-form-label text-md-right">{{ __('Giờ bắt đầu') }}</label>

                            <div class="col-md-6">
                                <input id="startTime" type="time" class="form-control" name="startTime" value="{{ old('startTime') }}" required autocomplete="new-dayExam">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dayExam" class="col-md-4 col-form-label text-md-right">{{ __('Giờ kết thúc') }}</label>

                            <div class="col-md-6">
                                <input id="endTime" type="time" class="form-control" name="endTime" value="{{ old('endTime') }}" required autocomplete="new-dayExam">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Tạo') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
