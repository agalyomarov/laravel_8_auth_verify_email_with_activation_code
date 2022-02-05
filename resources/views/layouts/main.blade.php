<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Auth</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ route('home') }}">test.com</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Главная</a>
                            </li>
                            @guest()
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('login') }}">Войти</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('register.show') }}">Зарегистрироватся</a>
                                </li>
                            @endguest
                            @auth()
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('profile.index') }}">Профил</a>
                                </li>
                            @endauth
                        </ul>
                        @auth()
                            <div class="d-flex">
                                Привет {{ auth()->user()->name }}
                            </div>
                            <div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button class="btn btn-outline-danger ms-3">
                                        Выйти
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </nav>
        </div>
    </div>

    @yield('content')
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
