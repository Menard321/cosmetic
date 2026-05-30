<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niffer Cosmetic</title>
    <!-- Google Fonts for Elegant Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- FontAwesome for Form Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- INTERNAL CSS -->
    <style>
        /* --- Global Resets & Styling --- */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            /* Soft aesthetic backdrop mimicking the original image vibe */
            background: linear-gradient(rgba(255, 255, 255, 0.45), rgba(255, 255, 255, 0.45)), 
                        url('https://images.unsplash.com/photo-1617897903246-719242758050?q=80&w=1920') no-repeat center center/cover;
            padding: 20px;
        }

        /* --- Container Structure --- */
        .auth-container {
            width: 100%;
            max-width: 1050px;
            display: flex;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 12px;
            overflow: hidden;
            margin: auto;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }

        /* --- Left Side Brand Panel --- */
        .brand-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            text-align: center;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo i {
            font-size: 3rem;
            color: #bc8e83;
            margin-bottom: 10px;
        }

        .logo h1 {
            font-size: 2.2rem;
            font-weight: 300;
            letter-spacing: 6px;
            color: #333;
        }

        .logo span {
            font-size: 0.8rem;
            letter-spacing: 8px;
            color: #777;
        }

        .brand-panel h2 {
            font-size: 1.2rem;
            font-weight: 400;
            letter-spacing: 2px;
            color: #444;
        }

        /* --- Right Side Form Panel --- */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .form-box {
            width: 100%;
            max-width: 420px;
            background: #fdfaf4; /* Elegant warm ivory tone from the image */
            padding: 35px 30px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .form-box h3 {
            font-size: 1.1rem;
            font-weight: 500;
            letter-spacing: 1.5px;
            color: #2c2c2c;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-box h3 span {
            font-size: 0.95rem;
            font-weight: 400;
        }

        /* --- Input Group & Fields --- */
        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #555;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-wrapper i {
            position: absolute;
            left: 15px;
            color: #888;
            font-size: 0.95rem;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #e0d8d0;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 0.9rem;
            color: #333;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .input-wrapper input:focus {
            border-color: #bc8e83;
        }

        /* --- Checkbox and Links --- */
        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 0.8rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            position: relative;
            cursor: pointer;
            color: #555;
            user-select: none;
        }

        .checkbox-container input {
            margin-right: 8px;
            accent-color: #bc8e83;
        }

        .checkbox-container a, .forgot-link, .switch-form-text a {
            color: #222;
            text-decoration: none;
            font-weight: 500;
        }

        .checkbox-container a:hover, .forgot-link:hover, .switch-form-text a:hover {
            text-decoration: underline;
        }

        /* --- Action Button --- */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #bc8e83; /* Soft Muted Dusty Rose */
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-submit:hover {
            background-color: #a8796f;
        }

        .switch-form-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.85rem;
            color: #666;
        }

        /* --- Utilities --- */
        .hidden {
            display: none !important;
        }

        footer {
            width: 100%;
            text-align: center;
            padding: 15px;
            font-size: 0.75rem;
            color: #fff;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.4);
            letter-spacing: 1px;
        }

        /* --- Responsive Adjustments --- */
        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                background: transparent;
                box-shadow: none;
                backdrop-filter: none;
            }
            .brand-panel {
                padding: 20px 0;
            }
            .brand-panel .logo h1 {
                color: #fff;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
            }
            .brand-panel .logo span, .brand-panel h2 {
                color: #fff;
            }
            .form-panel {
                padding: 10px 0;
            }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <!-- LEFT SIDE: Brand Presentation -->
        <div class="brand-panel">
            <div class="brand-content">
                <div class="logo">
                    <i class="fa-solid fa-spa"></i>
                    <h1>Niffer</h1>
                    <span>BEAUTY</span>
                </div>
                <h2>SIGN IN TO YOUR BEAUTY PORTAL</h2>
            </div>
        </div>

        <!-- RIGHT SIDE: Form Panel -->
        <div class="form-panel">
            
            <!-- LOGIN FORM -->
            <div class="form-box @if($errors->has('name') || $errors->has('password_confirmation')) hidden @endif" id="login-box">
                <h3>LOGIN FORM:</h3>
                
                @if (session('status'))
                    <div style="color: #3c763d; background: #dff0d8; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.85rem; border: 1px solid #d6e9c6; text-align: center;">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any() && !$errors->has('name') && !$errors->has('password_confirmation'))
                    <div style="color: #d9534f; background: #fdf7f7; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.85rem; border: 1px solid #ebccd1;">
                        <ul style="list-style: none; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="login-email">Username or Email</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-user"></i>
                            <input type="email" name="email" id="login-email" placeholder="example@email.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="login-password">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" id="login-password" placeholder="********" required autocomplete="current-password">
                        </div>
                    </div>

                    <div class="form-actions">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember" id="remember_me">
                            Stay Signed In
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        @endif
                    </div>

                    <button type="submit" class="btn-submit">LOG IN</button>
                </form>
                <p class="switch-form-text">New to Niffer? <a href="#" id="to-register">[Register Now]</a></p>
            </div>

            <!-- REGISTRATION FORM -->
            <div class="form-box @if(!$errors->has('name') && !$errors->has('password_confirmation')) hidden @endif" id="register-box">
                <h3>REGISTRATION FORM:<br><span>JOIN OUR Niffer Cosmetic COMMUNITY</span></h3>
                
                @if ($errors->any() && ($errors->has('name') || $errors->has('password_confirmation') || $errors->has('email')))
                    <div style="color: #d9534f; background: #fdf7f7; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.85rem; border: 1px solid #ebccd1;">
                        <ul style="list-style: none; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="reg-name">Full Name</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-user"></i>
                            <input type="text" name="name" id="reg-name" placeholder="user name" value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="reg-email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" name="email" id="reg-email" placeholder="janedoe@email.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="phone_display">Mobile Contact (for Bulk SMS)</label>
                        <div style="display: flex; gap: 10px;">
                            <div style="flex: 0 0 100px; position: relative;">
                                <select id="country_code" name="country_code" style="width: 100%; padding: 12px 5px; border: 1px solid #e0d8d0; border-radius: 6px; background: white; font-size: 0.85rem; appearance: none; cursor: pointer;">
                                    <option value="255" selected>🇹🇿 +255</option>
                                    <option value="254">🇰🇪 +254</option>
                                    <option value="256">🇺🇬 +256</option>
                                    <option value="250">🇷🇼 +250</option>
                                    <option value="257">🇧🇮 +257</option>
                                </select>
                                <i class="fa-solid fa-chevron-down" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 0.7rem; color: #888; pointer-events: none;"></i>
                            </div>
                            <div class="input-wrapper" style="flex: 1;">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                                <input type="tel" id="phone_display" placeholder="712345678" style="padding-left: 45px;" oninput="this.value = this.value.replace(/[^0-9]/g, ''); updateFullPhone()" required>
                            </div>
                        </div>
                        <p style="font-size: 0.65rem; color: #888; margin-top: 5px; font-style: italic;">Note: Enter number without leading zero (e.g. 7XXXXXXXX)</p>
                        <input type="hidden" name="phone" id="phone_full">
                    </div>

                    <script>
                        function updateFullPhone() {
                            const code = document.getElementById('country_code').value;
                            let number = document.getElementById('phone_display').value;
                            if (number.startsWith('0')) {
                                number = number.substring(1);
                            }
                            document.getElementById('phone_full').value = code + number;
                        }
                        document.getElementById('country_code').addEventListener('change', updateFullPhone);
                    </script>

                    <div class="input-group">
                        <label for="reg-password">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" id="reg-password" placeholder="Minimum 8 characters" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="reg-confirm">Confirm Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password_confirmation" id="reg-confirm" placeholder="••••••••" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-actions">
                        <label class="checkbox-container">
                            <input type="checkbox" required>
                            I agree to the <a href="#">[Terms & Conditions]</a> and <a href="#">[Privacy Policy]</a>
                        </label>
                    </div>

                    <button type="submit" class="btn-submit">REGISTER AS BEAUTY MEMBER</button>
                </form>
                <p class="switch-form-text">Already a member? <a href="#" id="to-login">[Sign In]</a></p>
            </div>

        </div>
    </div>

    <footer>
        <p>&copy; 2023 Niffer Cosmetic. All rights reserved.</p>
    </footer>

    <!-- JavaScript Toggle Logic -->
    <script>
        const loginBox = document.getElementById('login-box');
        const registerBox = document.getElementById('register-box');
        const toRegister = document.getElementById('to-register');
        const toLogin = document.getElementById('to-login');

        toRegister.addEventListener('click', (e) => {
            e.preventDefault();
            loginBox.classList.add('hidden');
            registerBox.classList.remove('hidden');
        });

        toLogin.addEventListener('click', (e) => {
            e.preventDefault();
            registerBox.classList.add('hidden');
            loginBox.classList.remove('hidden');
        });
    </script>
</body>
</html>