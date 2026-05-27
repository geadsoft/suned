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
            overflow:hidden;
            background: linear-gradient(135deg,#f5f7fb,#eef2f7);
            font-family: 'Segoe UI', sans-serif;
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
            max-width:850px;
            background:#fff;
            border-radius:25px;
            padding:40px;
            text-align:center;
            box-shadow:0 10px 40px rgba(0,0,0,.08);
            position:relative;
            overflow:hidden;
        }

        /* LOGO */
        .logo{
            width:420px;
            max-width:100%;
            margin-bottom:20px;
        }

        /* ANIMACION */
        .animation-wrapper{
            position:relative;
            height:320px;
            margin-top:10px;
        }

        .hourglass{
            width:180px;
            height:180px;
            border:10px solid #0B3A6E;
            border-radius:50%;
            position:absolute;
            left:50%;
            top:50%;
            transform:translate(-50%,-50%);
            animation: rotateGlass 6s infinite linear;
            box-shadow:0 0 30px rgba(0,0,0,.08);
            background:white;
        }

        .hourglass::before{
            content:'';
            position:absolute;
            top:20px;
            left:50%;
            transform:translateX(-50%);
            width:70px;
            height:70px;
            background:#dc3545;
            clip-path: polygon(0 0,100% 0,50% 100%);
            animation: sandTop 3s infinite;
        }

        .hourglass::after{
            content:'';
            position:absolute;
            bottom:20px;
            left:50%;
            transform:translateX(-50%);
            width:70px;
            height:70px;
            background:#dc3545;
            clip-path: polygon(50% 0,0 100%,100% 100%);
            animation: sandBottom 3s infinite;
        }

        @keyframes rotateGlass{
            0%{
                transform:translate(-50%,-50%) rotate(0deg);
            }

            100%{
                transform:translate(-50%,-50%) rotate(360deg);
            }
        }

        @keyframes sandTop{
            0%{
                transform:translateX(-50%) scaleY(1);
            }

            50%{
                transform:translateX(-50%) scaleY(.3);
            }

            100%{
                transform:translateX(-50%) scaleY(1);
            }
        }

        @keyframes sandBottom{
            0%{
                transform:translateX(-50%) scaleY(.3);
            }

            50%{
                transform:translateX(-50%) scaleY(1);
            }

            100%{
                transform:translateX(-50%) scaleY(.3);
            }
        }

        /* LOCK */
        .lock-icon{
            position:absolute;
            right:120px;
            top:90px;
            font-size:90px;
            color:#dc3545;
            animation:pulse 2s infinite;
        }

        @keyframes pulse{

            0%{
                transform:scale(1);
            }

            50%{
                transform:scale(1.15);
            }

            100%{
                transform:scale(1);
            }

        }

        .title{
            font-size:52px;
            font-weight:700;
            color:#0B3A6E;
        }

        .title span{
            color:#dc3545;
        }

        .subtitle{
            font-size:20px;
            color:#6c757d;
            margin-top:15px;
        }

        .btn-login{
            margin-top:30px;
            background:#0B3A6E;
            border:none;
            padding:14px 35px;
            font-size:18px;
            border-radius:12px;
            transition:.3s;
        }

        .btn-login:hover{
            transform:translateY(-3px);
            background:#082c54;
        }

        .info-box{
            margin-top:35px;
            background:#f8f9fa;
            border-radius:15px;
            padding:15px;
            color:#6c757d;
        }

        /* PARTICULAS */
        .circle{
            position:absolute;
            border-radius:50%;
            opacity:.15;
            animation:float 6s infinite ease-in-out;
        }

        .circle1{
            width:120px;
            height:120px;
            background:#0B3A6E;
            top:-40px;
            left:-40px;
        }

        .circle2{
            width:80px;
            height:80px;
            background:#dc3545;
            bottom:-20px;
            right:20px;
        }

        @keyframes float{

            0%{
                transform:translateY(0px);
            }

            50%{
                transform:translateY(-20px);
            }

            100%{
                transform:translateY(0px);
            }

        }

    </style>

</head>
<body>

<div class="session-container">

    <div class="session-card">

        <div class="circle circle1"></div>
        <div class="circle circle2"></div>

        <!-- LOGO -->
        <img src="{{ asset('images/logo-american.png') }}"
             class="logo"
             alt="American School">

        <!-- ANIMACION -->
        <div class="animation-wrapper">

            <div class="hourglass"></div>

            <div class="lock-icon">
                <i class="ri-lock-2-fill"></i>
            </div>

        </div>

        <!-- TEXTO -->
        <div class="title">
            Sesión <span>Expirada</span>
        </div>

        <div class="subtitle">
            Tu sesión finalizó por inactividad.<br>
            Por seguridad debes iniciar sesión nuevamente.
        </div>

        <!-- BOTON -->
        <a href="{{ route('login') }}"
           class="btn btn-primary btn-login">

            <i class="ri-login-circle-line"></i>
            Iniciar sesión nuevamente

        </a>

        <!-- INFO -->
        <div class="info-box">

            <i class="ri-information-line"></i>

            Por seguridad el sistema cerró automáticamente la sesión
            después de un período de inactividad.

        </div>

    </div>

</div>

</body>
</html>