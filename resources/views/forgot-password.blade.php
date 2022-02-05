@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <form class="w-50" method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Введите email для сброса парола</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
        @if (session('status'))
            <div class="row mt-4">
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            </div>
        @endif
    </div>
@endsection
