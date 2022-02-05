@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="w-50 alert alert-warning">
                Для продолжение регистрации введите код отправленный по вашему email почту
            </div>
        </div>
        <div class="row">
            <form action="{{ route('verification.verify') }}" method="post">
                @csrf
                <div class="col-7 mb-2">
                    {{ auth()->user()->email }}
                </div>
                <div class="col-7 mb-2">
                    <input type="text" name="activation_code">
                    @if (session('activation_code'))
                        <div class="text-danger">
                            {{ session('activation_code') }}
                        </div>
                    @endif
                </div>
                <div class="col-7 mb-2">
                    <button type="submit" class="btn btn-primary">
                        Отправить
                    </button>
                </div>
            </form>
        </div>
        <div class="row">
            <form action="{{ route('verification.send') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-outline-success">
                    Отправить код повторно
                </button>
            </form>
        </div>
        @if (Session('status'))
            <div class="btn btn-warning mt-4">
                {{ session('status') }}
            </div>
        @endif
    </div>
@endsection
