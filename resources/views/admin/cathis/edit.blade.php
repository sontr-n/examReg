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
                <div class="card-header">{{ __('Sửa ca thi') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.cathis.update', $cathi->id) }}">
                        @csrf
                        @method('PUT')
                    {{--
                        <div class="form-group row">
                            <label for="category_id" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                            <div class="col-md-6">
                                <select
                                    id="category_id"
                                    class="form-control"
                                    @error('category_id') is-invalid @enderror"
                                    name="category_id"
                                    value="{{ old('category_id') }}"
                                >
                                    <option value="0">Select parent</option>

                                    @foreach ($categories as $cate)
                                        <option
                                            value="{{ $cate->id }}"
                                            {{ (isset($cathi->category) && $cate->id == $cathi->category->id) || ($cate->id == old('category_id')) ? 'selected' : '' }}>
                                            {{ $cate->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    --}}
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Tên ca thi') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $cathi->name }}" required autocomplete="name" autofocus>

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
                                <textarea id="room" type="text" class="form-control @error('room') is-invalid @enderror" name="room" required autocomplete="room">{{ old('room') ?? $cathi->room }}</textarea>

                                @error('room')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="quantityPC" class="col-md-4 col-form-label text-md-right">{{ __('Số máy tính') }}</label>

                            <div class="col-md-6">
                                <input id="quantityPC" type="text" class="form-control @error('quantityPC') is-invalid @enderror" name="quantityPC" value="{{ old('quantityPC') ?? $cathi->quantityPC }}" required autocomplete="new-quantityPC">

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
                                <input id="dayExam" type="text" class="form-control" name="dayExam" value="{{ old('dayExam') ?? $cathi->dayExam }}" required autocomplete="new-dayExam">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Cập nhập') }}
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
