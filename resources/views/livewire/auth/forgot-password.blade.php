<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Forgot password</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            background: #0f1920;
            overflow-y: auto;
            padding: 20px 0;
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
            width: 48vh;
            max-width: 100%;
            filter: drop-shadow(0px 8px 12px rgba(0,0,0,0.4));
        }

        .left h1 {
            font-weight: 700;
            margin-top: 20px;
            letter-spacing: 1px;
        }

        
        .right {
            width: 50%;
            background: rgba(255,255,255,0.92);
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 80%;
            max-width: 420px;
        }

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
            transition: 0.3s ease;
        }

        .form-control:focus {
            border-color: #0aa34a !important;
            box-shadow: 0 0 10px rgba(26, 160, 73, 0.5);
            background: #ffffff;
        }

        .login-btn {
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

        .login-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 18px rgba(0,0,0,0.25);
        }

        a {
            text-decoration: none;
            color: #0b7b32;
        }

        .logo-box img {
            display: block;
            margin: 0 auto;
        }

        .error-text {
            color: #c53030;
            font-size: 0.9rem;
            margin-top: -8px;
            margin-bottom: 12px;
        }

        @media (max-width: 992px) {
            .wrapper {
                flex-direction: column;
                height: auto;
                margin: 40px 0;
            }

            .left, .right {
                width: 100%;
            }

            .right {
                padding: 40px 30px;
            }

            .login-box {
                width: 100%;
            }
        }

        @media (max-width: 600px) {
            body {
                padding: 16px 0;
            }

            .wrapper {
                width: 95%;
                margin: 20px 0;
                border-radius: 18px;
                box-shadow: 0 12px 30px rgba(0,0,0,0.35);
            }

            .left {
                padding: 28px 22px;
            }

            .left img {
                width: 65vw;
                max-width: 260px;
            }

            .right {
                padding: 32px 24px;
            }

            .login-box h4 {
                margin-bottom: 26px;
            }

            .input-group {
                width: 100%;
            }

            .login-btn {
                padding: 12px;
                margin-top: 8px;
            }
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
            <img src="{{ asset('imagenes/Farmer-bro.png') }}" alt="Ilustración agricultor">
            <h1>¿Olvidaste tu contraseña?</h1>
            <p style="max-width: 320px;">
                Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
            </p>
        </div>

        
        <div class="right">
            <div class="login-box">

                <div class="text-center mb-3 logo-box">
                    <img src="{{ asset('imagenes/logo.png') }}" alt="Logo" style="width: 110px;">
                </div>

                <h4>RECUPERAR CONTRASEÑA</h4>

                @if (session('status'))
                    <div class="alert alert-success text-center py-2 mb-3">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger py-2 mb-3">
                        Revisa el campo marcado para continuar.
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
                    @csrf

                    
                    <div class="input-group mb-3">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="email@example.com"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror

                    <button class="login-btn" type="submit" data-test="email-password-reset-link-button">
                        {{ __('Email password reset link') }}
                    </button>
                </form>

                <div class="mt-3 text-center text-sm">
                    <span>{{ __('Or, return to') }}</span>
                    <a href="{{ route('login') }}">{{ __('log in') }}</a>
                </div>

            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
