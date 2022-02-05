@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="w-50 mt-5 m-auto">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                        @error('email')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Новый парол</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="password">
                        @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Подверждение новый парола</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Код активации</label>
                        <input type="text" class="form-control" name="activation_code">
                        @error('actication_code')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @if (session('code'))
                            <div class="text-danger">
                                {{ session('code') }}
                            </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between ps-3 pe-3">
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </div>
                </form>
            </div>
            <div class="w-50 mt-5 m-auto">
                <a href="{{ route('password.request') }}" class="btn btn-outline-success">Отправить код повторно</a>
            </div>
            @if (session('status'))
                <div class="w-50 mt-5 m-auto alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
@endsection
