<div>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Iconos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        #bg-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -10;
            filter: brightness(0.45);
        }

        .overlay-gradient {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(0,0,0,0.65), rgba(0,80,45,0.5));
            z-index: -5;
        }

        body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .wrapper {
            width: 90%;
            max-width: 1200px;
            height: 75%;
            background: rgba(255,255,255,0.12);
            border-radius: 22px;
            backdrop-filter: blur(18px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.45);
            display: flex;
            overflow: hidden;
        }

        /* IZQUIERDA */
        .left {
            background: linear-gradient(135deg, rgba(0,120,60,0.55), rgba(0,180,90,0.45));
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
        }

        .left img {
            width: 90%;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0px 8px 12px rgba(0,0,0,0.4));
        }

        .left h1 {
            font-weight: 700;
            margin-top: 20px;
            letter-spacing: 1px;
        }

        /* DERECHA */
        .right {
            width: 50%;
            background: rgba(255,255,255,0.92);
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box { width: 80%; }

        .login-box h4 {
            text-align: center;
            color: #0b6d35;
            font-weight: 700;
            margin-bottom: 35px;
        }

        .input-group-text {
            background: #e9fbee;
            border-right: none;
            color: #0b7b32;
        }

        .form-control {
            border-left: none;
            background: #e9fbee;
            border-radius: 50px;
            height: 48px;
        }

        .form-control:focus {
            border-color: #0aa34a !important;
            box-shadow: 0 0 10px rgba(26,160,73,0.5);
            background: #fff;
        }

        .login-btn, .register-btn {
            background: linear-gradient(135deg, #0ba64b, #0fd36a);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 50px;
            padding: 12px;
            width: 100%;
            margin-top: 10px;
            transition: 0.25s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .login-btn:hover, .register-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        }

        .register-btn {
            background: linear-gradient(135deg, #0a853c, #13c95d);
        }

        .error-text {
            font-size: 14px;
            margin-top: 4px;
            color: red;
            margin-left: 55px;
        }
    </style>
</head>
<body>

<video autoplay muted loop id="bg-video">
    <source src="{{ asset('videos/videoplayback.mp4') }}" type="video/mp4">
</video>

<div class="overlay-gradient"></div>

<div class="wrapper">

    <div class="left">
        <img src="{{ asset('imagenes/Farmer-bro.png') }}" alt="">
        <h1>Bienvenido</h1>
        <p style="max-width: 320px;">Accede a la plataforma de forma segura para gestionar tus servicios.</p>
    </div>

    <div class="right">
        <div class="login-box">

            <div class="text-center mb-3">
                <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" style="width: 110px;">
            </div>

            <h4>INICIO DE SESIÓN</h4>

            
            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                
                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Correo"
                           value="{{ old('email') }}">
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                
                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Contraseña">
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <input type="checkbox" name="remember">
                        <label>Recordarme</label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>

                <button type="submit" class="login-btn">ENTRAR</button>

                <a href="{{ route('register') }}">
                    <button type="button" class="register-btn mt-3">REGISTRAR</button>
                </a>
            </form>

        </div>
    </div>

</div>

</body>
</html>
</div>
