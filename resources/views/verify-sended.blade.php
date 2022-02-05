@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="w-50 alert alert-info">
                Писмо для подверждение email повторно отправлен
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <a href="{{ route('verification.notice') }}" class="btn btn-outline-success">
                    Вернутся назад
                </a>
            </div>
        </div>
    </div>
@endsection
