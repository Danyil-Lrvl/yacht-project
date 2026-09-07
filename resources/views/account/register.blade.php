<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Реєстрація - Yacht Club</title>
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f3d3e; }
        .btn-border { border: 1px solid #2b8a8c; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6">

    <div class="w-full max-w-md bg-[#1a6668] p-8 rounded-3xl shadow-2xl border border-[#2b8a8c] text-white">
        
        <div class="flex items-center justify-center mb-6 gap-4">
            <img src="{{ asset('images/main-logo.png') }}" alt="Logo" class="h-14 w-14 object-contain">
            <h2 class="text-2xl font-bold tracking-widest">Yacht Club</h2>
        </div>

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-600/30 border border-red-400 text-red-200 rounded-xl">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('client.register') }}" method="POST">
            @csrf
            <h3 class="text-xl font-bold mb-4 text-cyan-100">Створити акаунт</h3>

            <div class="mb-4">
                <label class="block text-sm text-cyan-200 mb-1">ПІБ (Прізвище, Ім'я, По батькові)</label>
                <input type="text" name="name" required class="w-full bg-[#0f3d3e] text-white px-4 py-2.5 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
            </div>
            
            <div class="mb-4">
                <label class="block text-sm text-cyan-200 mb-1">Email</label>
                <input type="email" name="email" required class="w-full bg-[#0f3d3e] text-white px-4 py-2.5 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
            </div>

            <div class="mb-6">
                <label class="block text-sm text-cyan-200 mb-1">Пароль</label>
                <input type="password" name="password" required class="w-full bg-[#0f3d3e] text-white px-4 py-2.5 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
            </div>

            <button type="submit" class="w-full py-3 bg-white text-[#1a6668] font-bold rounded-full hover:bg-cyan-100 transition btn-border">
                Зареєструватися
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-sm text-cyan-200 hover:text-white underline">← На головну</a>
        </div>
    </div>

</body>
</html>