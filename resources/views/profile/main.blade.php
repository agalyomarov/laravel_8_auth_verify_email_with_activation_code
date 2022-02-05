@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row mt-5">
            <div class="w-50">

                <form action="{{ route('profile.name.update') }}" method="POST">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Имя</label>
                        <input type="text" class="form-control" aria-describedby="emailHelp" name="name" value="{{ old('name', $data['name']) }}">
                        @error('name')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </form>
                <form action="{{ route('profile.email.update') }}" method="POST" class="mt-4" method="POST">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" aria-describedby="emailHelp" name="email" value="{{ old('email', $data['email']) }}">
                        <input type="hidden" class="form-control" id="exampleInputEmail2" aria-describedby="emailHelp2" name="user_id" value="{{ $data['id'] }}">

                        @error('email')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </form>

                <form action="{{ route('profile.password.update') }}" method="POST" class="mt-4">
                    @method('patch')
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Старый парол</label>
                        <input type="password" class="form-control" name="old_password">
                        @error('old_password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Новый парол</label>
                        <input type="password" class="form-control" name="password">
                        @error('password')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Подвержите новый парол</label>
                        <input type="password" class="form-control" name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                    @if (session('status'))
                        <div class="mt-3 w-50 alert alert-warning">
                            {{ session('status') }}
                        </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
@endsection
