@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="w-50 alert alert-warning">
                Подвердите новый Email
            </div>
        </div>
        <div class="row">
            <form action="{{ route('verification.send') }}" method="post">
                @csrf
                <button type="submit" class="btn btn-outline-success">
                    Отправить ссылку для подверждение
                </button>
            </form>
        </div>
    </div>
@endsection
