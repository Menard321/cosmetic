<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Angels Beauty - Private Access</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" />
    <style>
        :root { --primary: #735c00; --gold-gradient: linear-gradient(135deg, #735c00 0%, #a68c36 100%); }
        body { font-family: 'Inter', sans-serif; }
        .heading-font { font-family: 'Playfair Display', serif; }
        
        .auth-container {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/cosmetic_auth_split_bg_1779205834623.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 24px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            width: 100%;
            max-width: 460px;
            padding: 48px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: cardEnter 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes cardEnter {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .input-group {
            position: relative;
            margin-bottom: 32px;
        }

        .premium-input {
            width: 100%;
            background: #fdfaf3;
            border: 1.5px solid #e2e2e2;
            padding: 14px 16px 14px 48px;
            font-size: 15px;
            transition: all 0.3s ease;
            color: #1a1c1c;
        }

        .premium-input:focus {
            outline: none;
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(115, 92, 0, 0.1);
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #8c887d;
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .premium-input:focus + .input-icon {
            color: var(--primary);
        }

        .auth-button {
            background: var(--gold-gradient);
            color: white;
            padding: 16px;
            width: 100%;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .auth-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(115, 92, 0, 0.3);
            filter: brightness(1.1);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="login-card">
            <!-- Brand Header -->
            <div class="text-center mb-10">
                <a href="/" class="heading-font text-4xl font-bold tracking-tighter text-gray-900">
                   <span class="text-primary italic">Angels Beauty</span>
                </a>
                <p class="text-[10px] uppercase font-bold tracking-[0.4em] text-gray-400 mt-4">Private Portal Access</p>
            </div>

            <h2 class="heading-font text-2xl text-center text-gray-800 mb-8">Welcome Back</h2>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Identity -->
                <div class="input-group">
                    <label class="text-[10px] uppercase font-bold tracking-widest text-gray-500 block mb-2">Member Email</label>
                    <div class="relative">
                        <input type="email" name="email" required autofocus class="premium-input" placeholder="Enter your email signature">
                        <span class="material-symbols-outlined input-icon">mail</span>
                    </div>
                </div>

                <!-- Security -->
                <div class="input-group">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-[10px] uppercase font-bold tracking-widest text-gray-500 block">Encryption Key</label>
                        <a href="#" class="text-[9px] uppercase font-bold text-primary tracking-widest hover:underline">Lost Access?</a>
                    </div>
                    <div class="relative">
                        <input type="password" name="password" required class="premium-input" placeholder="••••••••">
                        <span class="material-symbols-outlined input-icon">lock</span>
                    </div>
                </div>

                <!-- Remember -->
                <div class="flex items-center mb-8">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary">
                        <span class="ml-3 text-[11px] text-gray-500 font-medium">Keep me authenticated for 30 days</span>
                    </label>
                </div>

                <button type="submit" class="auth-button">
                    Secure Entry
                </button>

                <!-- Footer -->
                <div class="mt-10 pt-8 border-t border-gray-100 text-center">
                    <p class="text-[11px] text-gray-400 mb-4">NOT A REGISTERED ENTITY?</p>
                    <a href="{{ route('register') }}" class="text-xs font-bold text-gray-900 border-b-2 border-primary pb-1 hover:text-primary transition-all">
                        BECOME A MEMBER
                    </a>
                </div>
            </form>

            <!-- Trust Signals -->
            <div class="mt-12 flex justify-center items-center gap-6 opacity-40">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">verified</span>
                    <span class="text-[9px] font-bold tracking-widest">AUTHENTIC</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">shield_person</span>
                    <span class="text-[9px] font-bold tracking-widest">PROTECTED</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
