<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Expirada</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Remixicon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">

    <style>

        body{
            margin:0;
            height:100vh;
            background:#f5f7fb;
            font-family:'Segoe UI', sans-serif;
        }

        .session-container{
            height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
        }

        .session-card{
            width:100%;
            max-width:700px;
            background:#fff;
            border-radius:20px;
            padding:40px 30px;
            text-align:center;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }

        .logo{
            width:420px;
            max-width:100%;
            margin-bottom:25px;
        }

        .btn-login{
            background:#0B3A6E;
            border:none;
            padding:14px 35px;
            font-size:18px;
            border-radius:12px;
            transition:.3s;
            margin-top:10px;
        }

        .btn-login:hover{
            background:#082c54;
        }

        .session-alert{
            display:flex;
            align-items:center;
            gap:12px;
            max-width:500px;
            margin:30px auto 0;
            padding:14px 18px;
            border:1px solid #dfe5f1;
            border-radius:12px;
            background:#fff;
            color:#5b6780;
            text-align:left;
        }

        .session-alert .icon{
            width:34px;
            height:34px;
            min-width:34px;
            border-radius:50%;
            background:#6f8fd9;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:18px;
        }

        .session-alert .message{
            font-size:14px;
            line-height:1.4;
        }

    </style>

</head>

<body>

<div class="session-container">

    <div class="session-card">

        <!-- IMAGEN -->
        <img src="{{ URL::asset('assets/images/sesion-expirada.png') }}"
             class="logo"
             alt="Sesión Expirada">

        <!-- BOTÓN -->
        <div>
            <a href="{{ route('login') }}"
               class="btn btn-primary btn-login">

                <i class="ri-login-circle-line"></i>
                Iniciar sesión nuevamente

            </a>
        </div>

        <!-- ALERTA -->
        <div class="session-alert">

            <div class="icon">
                <i class="ri-information-line"></i>
            </div>

            <div class="message">
                Por tu seguridad, cerramos tu sesión automáticamente
                después de un período de inactividad.
            </div>

        </div>

    </div>

</div>

</body>
</html>