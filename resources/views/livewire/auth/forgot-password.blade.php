<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        #bg-video {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            z-index: -10;
            filter: brightness(0.45);
        }

        .overlay-gradient {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,80,45,0.5));
            z-index: -5;
        }

        body {
            height: 100vh; margin: 0;
            display: flex; justify-content: center; align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .wrapper {
            width: 90%; max-width: 1200px; height: 75%;
            background: rgba(255,255,255,0.12);
            border-radius: 22px; backdrop-filter: blur(18px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.45);
            display: flex; overflow: hidden;
        }

        .left {
            background: linear-gradient(135deg, rgba(0,120,60,0.55), rgba(0,180,90,0.45));
            width: 50%; padding: 40px;
            display: flex; flex-direction: column; justify-content: center; align-items: center;
            color: white; text-align: center;
        }

        .right {
            width: 50%; background: rgba(255,255,255,0.92);
            padding: 60px; display: flex;
            align-items: center; justify-content: center;
        }

        .forgot-box { width: 80%; }
        .forgot-box h4 {
            text-align: center; color: #0b6d35;
            font-weight: 700; margin-bottom: 35px;
        }

        .input-group-text {
            background: #e9fbee; border-right: none; color: #0b7b32;
        }

        .form-control {
            border-left: none; background: #e9fbee;
            border-radius: 50px; height: 48px; transition: 0.3s ease;
        }

        .form-control:focus {
            border-color: #0aa34a !important;
            box-shadow: 0 0 10px rgba(26,160,73,0.5);
            background: #ffffff;
        }

        .send-btn, .login-btn {
            background: linear-gradient(135deg, #0ba64b, #0fd36a);
            border: none; color: white;
            font-weight: bold; border-radius: 50px;
            padding: 12px; width: 100%; margin-top: 10px;
            transition: 0.25s; box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .send-btn:hover, .login-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        }

        .login-btn {
            background: linear-gradient(135deg, #0a853c, #13c95d);
        }

        a { text-decoration: none; color: #0b7b32; }
    </style>
</head>

<body>

<video autoplay muted loop id="bg-video">
    <source src="{{ asset('videos/videoplayback.mp4') }}" type="video/mp4">
</video>

<div class="overlay-gradient"></div>

<div class="wrapper">

    
    <div class="left">
        <img src="{{ asset('imagenes/Farmer-bro.png') }}" alt="" style="width: 48vh;">
        <h1>¿Olvidaste tu contraseña?</h1>
        <p style="max-width: 320px;">Ingresa tu correo para enviarte un enlace seguro de recuperación.</p>
    </div>

    
    <div class="right">
        <div class="forgot-box">

            <div class="text-center mb-3">
                <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" style="width: 110px;">
            </div>

            <h4>RECUPERAR CONTRASEÑA</h4>

            
            @if (session('status'))
                <div class="alert alert-success text-center">{{ session('status') }}</div>
            @endif

            
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                
                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="tuemail@ejemplo.com"
                           value="{{ old('email') }}">
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <button type="submit" class="send-btn">ENVIAR ENLACE</button>

                <a href="{{ route('login') }}">
                    <button type="button" class="login-btn mt-3">VOLVER AL LOGIN</button>
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>
