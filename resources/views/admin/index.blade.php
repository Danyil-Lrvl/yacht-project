<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Панель Адміністратора | Nautilus Expedition</title>
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    
    <!-- Підключаємо стилі -->
    @include('admin.styles')
</head>
<body class="p-10 text-white relative min-h-screen">

    <!-- МОДАЛЬНЕ ВІКНО АВТОРИЗАЦІЇ -->
    <div id="authModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-md">
        <div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] max-w-md w-full shadow-2xl text-center">
            <h2 class="text-2xl font-bold mb-2 text-cyan-300">Панель адміністратора</h2>
            <p class="text-sm text-cyan-200/70 mb-6">Введіть пароль адміна для доступу</p>
            
            <form id="adminAuthForm" onsubmit="checkAdminPassword(event)">
                <input type="password" id="adminPassword" placeholder="Пароль..." required 
                    class="w-full p-3 mb-4 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white placeholder-cyan-200/40 focus:outline-none focus:border-cyan-400">
                <div id="errorMsg" class="text-rose-400 text-xs mb-4 hidden">Невірний пароль! Спробуйте ще раз.</div>
                <button type="submit" class="w-full py-3 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition">Увійти</button>
            </form>
        </div>
    </div>

    <!-- ОСНОВНИЙ КОНТЕЙНЕР АДМІНКИ (БЛУРИТЬСЯ) -->
    <div id="adminContent" class="max-w-6xl mx-auto filter blur-lg transition-all duration-500 pointer-events-none select-none">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-bold text-cyan-300">Панель адміністратора</h1>
            <a href="{{ url('/') }}" class="px-6 py-2 bg-[#1a6668] border border-[#2b8a8c] rounded-full hover:bg-[#2b8a8c] transition">&larr; На сайт</a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-600/30 border border-emerald-500 rounded-2xl text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <!-- Навігація або основний блок адмінки -->
        <div class="bg-[#1a6668]/40 border border-[#2b8a8c] p-6 rounded-3xl mb-8 flex gap-4 flex-wrap">
            <a href="{{ route('admin.rent') }}" class="px-5 py-2.5 bg-[#1a6668] hover:bg-[#2b8a8c] rounded-xl transition font-medium">Оренда</a>
            <a href="{{ route('admin.buy') }}" class="px-5 py-2.5 bg-[#1a6668] hover:bg-[#2b8a8c] rounded-xl transition font-medium">Покупка</a>
            <a href="{{ route('admin.types') }}" class="px-5 py-2.5 bg-[#1a6668] hover:bg-[#2b8a8c] rounded-xl transition font-medium">Типи яхт</a>
            <a href="{{ route('admin.yachts') }}" class="px-5 py-2.5 bg-[#1a6668] hover:bg-[#2b8a8c] rounded-xl transition font-medium">Яхти</a>
            <a href="{{ route('admin.photos') }}" class="px-5 py-2.5 bg-[#1a6668] hover:bg-[#2b8a8c] rounded-xl transition font-medium">Фото</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Ініціалізація кастомного календаря Flatpickr
        flatpickr(".custom-datepicker", {
            dateFormat: "Y-m-d",
            "locale": "uk",
            disableMobile: "true",
            theme: "dark"
        });

        // Безпечна перевірка пароля через сервер
        function checkAdminPassword(event) {
            event.preventDefault();
            const pass = document.getElementById('adminPassword').value;

            fetch('/admin/check-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password: pass })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('authModal').classList.add('hidden');
                    const content = document.getElementById('adminContent');
                    content.classList.remove('filter', 'blur-lg', 'pointer-events-none', 'select-none');
                } else {
                    document.getElementById('errorMsg').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Помилка:', error);
                document.getElementById('errorMsg').classList.remove('hidden');
            });
        }
    </script>
</body>
</html>