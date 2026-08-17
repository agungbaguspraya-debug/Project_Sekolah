<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Portal Sekolah') }} - Login</title>

        <!-- Fonts & CSS -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: radial-gradient(circle at 15% 15%, #1e1b4b 0%, #0f172a 45%, #020617 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0;
                padding: 20px;
                color: #f8fafc;
                position: relative;
                overflow-x: hidden;
            }

            /* Ambient Glow Background Orbs */
            .glow-orb-1 {
                position: absolute;
                top: -100px;
                left: -100px;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, rgba(0, 0, 0, 0) 70%);
                border-radius: 50%;
                pointer-events: none;
            }

            .glow-orb-2 {
                position: absolute;
                bottom: -100px;
                right: -100px;
                width: 450px;
                height: 450px;
                background: radial-gradient(circle, rgba(168, 85, 247, 0.2) 0%, rgba(0, 0, 0, 0) 70%);
                border-radius: 50%;
                pointer-events: none;
            }

            /* Glassmorphism Card Container */
            .glass-card {
                background: rgba(30, 41, 59, 0.7);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.12);
                border-radius: 20px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
                width: 100%;
                max-width: 440px;
                padding: 40px 32px;
                z-index: 10;
            }

            .brand-icon-box {
                width: 64px;
                height: 64px;
                background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
                border-radius: 16px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 16px auto;
                box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
            }

            .form-control-custom {
                background-color: rgba(15, 23, 42, 0.6) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                color: #ffffff !important;
                border-radius: 10px !important;
                padding: 12px 16px 12px 42px !important;
                font-size: 0.95rem !important;
                transition: all 0.3s ease !important;
            }

            .form-control-custom:focus {
                background-color: rgba(15, 23, 42, 0.9) !important;
                border-color: #6366f1 !important;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.25) !important;
            }

            .input-group-icon {
                position: absolute;
                left: 14px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                font-size: 1.1rem;
                z-index: 5;
            }

            .btn-login {
                background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
                border: none;
                color: #ffffff;
                font-weight: 600;
                padding: 12px 24px;
                border-radius: 10px;
                width: 100%;
                font-size: 1rem;
                letter-spacing: 0.5px;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(37, 99, 235, 0.35);
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(37, 99, 235, 0.5);
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="glow-orb-1"></div>
        <div class="glow-orb-2"></div>

        <div class="glass-card">
            {{ $slot }}
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('click', function(e) {
                const btn = e.target.closest('.toggle-password');
                if (btn) {
                    const targetId = btn.getAttribute('data-target');
                    let input = targetId ? document.getElementById(targetId) : null;
                    if (!input) {
                        const container = btn.closest('.position-relative') || btn.parentElement;
                        input = container ? container.querySelector('input') : null;
                    }
                    if (input) {
                        const isPassword = input.type === 'password';
                        input.type = isPassword ? 'text' : 'password';
                        const icon = btn.querySelector('i');
                        if (icon) {
                            if (isPassword) {
                                icon.className = 'bi bi-eye-fill fs-5 text-warning';
                            } else {
                                icon.className = 'bi bi-eye-slash-fill fs-5';
                            }
                        }
                    }
                }
            });
        </script>
    </body>
</html>
