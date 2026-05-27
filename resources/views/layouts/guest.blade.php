<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Angels Beauty') }}</title>

        <!-- Fonts: Playfair Display for headings, Inter for body -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
        
        <!-- Font Awesome & Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            :root {
                --primary: #735c00; /* Deep Gold to match the store aesthetic */
                --secondary: #574500;
                --accent: #fbcfe8;
                --background: #ffffff;
            }

            body {
                font-family: 'Inter', sans-serif;
                margin: 0;
                padding: 0;
                overflow-x: hidden;
            }

            .heading-font {
                font-family: 'Playfair Display', serif;
            }

            .auth-grid {
                display: grid;
                grid-template-cols: 1fr;
                min-height: 100vh;
            }

            @media (min-width: 1024px) {
                .auth-grid {
                    grid-template-cols: 1fr 1fr;
                }
            }

            .auth-image-side {
                display: none;
                position: relative;
                overflow: hidden;
                background: #fdfaf3;
            }

            @media (min-width: 1024px) {
                .auth-image-side {
                    display: block;
                }
            }

            .auth-image-side img {
                width: 100%;
                height: 100%;
                object-cover: cover;
                animation: zoomIn 15s ease-out infinite alternate;
            }

            @keyframes zoomIn {
                from { transform: scale(1); }
                to { transform: scale(1.1); }
            }

            .auth-image-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 60px;
                color: white;
            }

            .auth-form-side {
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 40px;
                background: white;
            }

            .form-container {
                width: 100%;
                max-width: 440px;
                animation: fadeIn 0.8s ease-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .auth-btn-primary {
                background: #1a1c1c; /* Sharp professional black */
                color: white;
                padding: 16px;
                border-radius: 0px; /* Sharp modernist look */
                font-weight: 600;
                text-align: center;
                width: 100%;
                display: block;
                transition: all 0.3s ease;
                border: none;
                cursor: pointer;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                font-size: 14px;
            }

            .auth-btn-primary:hover {
                background: var(--primary);
                box-shadow: 0 10px 20px rgba(115, 92, 0, 0.2);
            }

            .form-input-premium {
                width: 100%;
                background: transparent;
                border: none;
                border-bottom: 1.5px solid #e2e2e2;
                border-radius: 0px;
                padding: 12px 2px;
                font-size: 16px;
                transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                margin-top: 4px;
            }

            .form-group {
                position: relative;
                margin-bottom: 24px;
            }

            .form-input-premium:focus {
                outline: none;
                border-color: var(--primary);
                padding-left: 8px;
            }

            .social-btn {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 12px;
                padding: 12px;
                border: 1px solid #e2e2e2;
                background: white;
                color: #1a1c1c;
                font-size: 13px;
                font-weight: 600;
                transition: all 0.3s ease;
                cursor: pointer;
                width: 100%;
            }

            .social-btn:hover {
                background: #f9f9f9;
                border-color: #1a1c1c;
            }

            .trust-badge {
                display: flex;
                align-items: center;
                gap: 8px;
                color: #8c887d;
                font-size: 10px;
                text-transform: uppercase;
                letter-spacing: 0.1em;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="auth-grid">
            <!-- Left Side: Cinematic Image -->
            <div class="auth-image-side">
                <img src="/cosmetic_auth_split_bg_1779205834623.png" alt="Angels Beauty Luxury">
                <div class="auth-image-overlay">
                    <h2 class="heading-font text-5xl mb-4">Timeless Radiance.</h2>
                    <p class="text-white/80 font-light tracking-wide max-w-sm">Join our exclusive community of beauty enthusiasts in Tanzania and discover a world of authentic luxury products.</p>
                </div>
            </div>

            <!-- Right Side: Clean Modern Form -->
            <div class="auth-form-side">
                <div class="form-container">
                    <div class="mb-12">
                        <a href="/" class="heading-font text-3xl font-bold text-on-surface tracking-tighter">
                            Silk <span class="text-primary italic">Beauty</span>
                        </a>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
