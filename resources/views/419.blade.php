<!DOCTYPE html>
<html>
<head>
    <title>Sesión Expirada</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div class="container text-center mt-5">

    <h1>Sesión expirada</h1>

    <p>
        Su sesión terminó por inactividad.
    </p>

    <a href="{{ route('login') }}" class="btn btn-primary">
        Volver a iniciar sesión
    </a>

</div>

</body>
</html>