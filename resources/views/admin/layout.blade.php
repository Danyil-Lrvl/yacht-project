<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Панель Адміністратора | Nautilus Expedition')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    <!-- Підключаємо Tailwind CSS, щоб стилі працювали -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    
    @include('admin.styles')
</head>
<body style="background-color: #0b3c40; color: #fff; font-family: sans-serif; margin: 0; padding: 20px;" class="min-h-screen relative">

    @php
        $isAdminLoggedIn = session('admin_logged_in', false);
    @endphp

    <!-- МОДАЛЬНЕ ВІКНО АВТОРИЗАЦІЇ ЗА ПАРОЛЕМ З .env -->
    <div id="authModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-md {{ $isAdminLoggedIn ? 'hidden' : '' }}">
        <div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] max-w-md w-full shadow-2xl text-center">
            <h2 class="text-2xl font-bold mb-2 text-cyan-300">Панель адміністратора</h2>
            <p class="text-sm text-cyan-200/70 mb-6">Введіть пароль адміна для доступу</p>
            
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <input type="password" name="password" placeholder="Пароль..." required 
                    class="w-full p-3 mb-4 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white placeholder-cyan-200/40 focus:outline-none focus:border-cyan-400">
                
                @if($errors->has('password'))
                    <div class="text-rose-400 text-xs mb-4">Невірний пароль! Спробуйте ще раз.</div>
                @endif

                <button type="submit" class="w-full py-3 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition cursor-pointer">Увійти</button>
            </form>
        </div>
    </div>

    <!-- ОСНОВНИЙ КОНТЕЙНЕР АДМІНКИ (БЛУРИТЬСЯ ДО ВВЕДЕННЯ ПАРОЛЯ) -->
    <div id="adminContent" class="transition-all duration-500 {{ $isAdminLoggedIn ? '' : 'filter blur-lg pointer-events-none select-none' }}">
        
        <!-- Верхня панель -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="color: #4ce0d2; font-size: 28px; margin: 0;">Адмін панель</h1>
            
            <form action="{{ route('admin.logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-size: 15px; font-weight: bold; transition: all 0.2s;" onmouseover="this.style.background='rgba(239, 68, 68, 0.4)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.2)'">Вийти</button>
            </form>
        </div>

        <!-- 5 кнопок навігації -->
        <div style="display: flex; gap: 10px; margin-bottom: 30px; flex-wrap: wrap;">
            <a href="{{ route('admin.rent') }}" style="padding: 10px 20px; border-radius: 8px; text-decoration: none; background: {{ request()->routeIs('admin.rent') ? '#4ce0d2' : '#1d5f64' }}; color: {{ request()->routeIs('admin.rent') ? '#0b3c40' : '#fff' }}; font-weight: bold;">Оренда</a>
            
            <a href="{{ route('admin.buy') }}" style="padding: 10px 20px; border-radius: 8px; text-decoration: none; background: {{ request()->routeIs('admin.buy') ? '#4ce0d2' : '#1d5f64' }}; color: {{ request()->routeIs('admin.buy') ? '#0b3c40' : '#fff' }}; font-weight: bold;">Купівля</a>
            
            <a href="{{ route('admin.types') }}" style="padding: 10px 20px; border-radius: 8px; text-decoration: none; background: {{ request()->routeIs('admin.types') ? '#4ce0d2' : '#1d5f64' }}; color: {{ request()->routeIs('admin.types') ? '#0b3c40' : '#fff' }}; font-weight: bold;">Типи</a>
            
            <a href="{{ route('admin.yachts') }}" style="padding: 10px 20px; border-radius: 8px; text-decoration: none; background: {{ request()->routeIs('admin.yachts') ? '#4ce0d2' : '#1d5f64' }}; color: {{ request()->routeIs('admin.yachts') ? '#0b3c40' : '#fff' }}; font-weight: bold;">Яхти</a>
            
            <a href="{{ route('admin.photos') }}" style="padding: 10px 20px; border-radius: 8px; text-decoration: none; background: {{ request()->routeIs('admin.photos') ? '#4ce0d2' : '#1d5f64' }}; color: {{ request()->routeIs('admin.photos') ? '#0b3c40' : '#fff' }}; font-weight: bold;">Фото</a>
        </div>

        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; padding: 15px; border-radius: 12px; margin-bottom: 20px; color: #6ee7b7;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Основний контент конкретної сторінки -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <!-- Підключення календаря -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/uk.js"></script>
    <script>
        flatpickr(".custom-datepicker", {
            dateFormat: "Y-m-d",
            locale: "uk",
            disableMobile: "true",
            theme: "dark"
        });
    </script>
</body>
</html>