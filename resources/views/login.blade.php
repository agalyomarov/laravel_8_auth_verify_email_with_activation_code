@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="w-50 mt-5 m-auto">
                <form action="{{ route('login.authenticate') }}" method="POST">
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
                        <label for="exampleInputEmail1" class="form-label">Парол</label>
                        <input type="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="password">
                        @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember_me" value="true">
                        <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
                    </div>
                    <div class="d-flex justify-content-between ps-3 pe-3">
                        <button type="submit" class="btn btn-primary">Войти</button>
                        <a href="{{ route('password.request') }}" class="ms-3">Забыли парол</a>
                    </div>
                </form>
                @if (session('status'))
                    <div class="mt-4 alert alert-info">
                        {{ session('status') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
