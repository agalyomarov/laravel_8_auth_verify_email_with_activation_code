<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>
<style>
    .container {
        width: 100%;
        /* margin: auto; */
        height: 100%;
        position: relative;
        text-align: center;
    }

    .btn {
        text-decoration: none;
        /* display: inline-block; */
        background: #000;
        color: white;
        line-height: 30px;
        padding: 0 20px 0 20px;
        border-radius: 5px;
        position: absolute;
        top: 50vh;
        /* left: 50vw; */
    }

    .btn-href {
        position: absolute;
        top: 80vh;
    }

</style>

<body>
    <div class="container">
        <h1 class="btn">{{ $code }}</h1>
    </div>
</body>

</html>
