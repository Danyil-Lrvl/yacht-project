<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Мої дані — Yacht Club</title>
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f3d3e; }
        .btn-border { border: 1px solid #2b8a8c; }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0f3d3e; }
        ::-webkit-scrollbar-thumb { background: #2b8a8c; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #06b6d4; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Ліве меню -->
    <nav class="w-64 bg-[#105657] text-white p-8 rounded-r-[3rem] sticky top-0 h-screen flex flex-col justify-between">
        <div class="space-y-4">
            <a href="{{ url('/') }}" class="block text-2xl font-bold mb-6 text-center">Yacht Club</a>
            <a href="{{ url('/') }}" class="block px-4 py-3 rounded-full text-lg text-center bg-[#0a3536] hover:bg-[#0f3d3e] btn-border transition">Головна</a>
            <a href="{{ url('/yachts/rent') }}" class="block px-4 py-3 rounded-full text-lg text-center bg-[#0a3536] hover:bg-[#0f3d3e] btn-border transition">Оренда яхт</a>
            <a href="{{ url('/yachts/buy') }}" class="block px-4 py-3 rounded-full text-lg text-center bg-[#0a3536] hover:bg-[#0f3d3e] btn-border transition">Купівля яхт</a>
        </div>

        <div class="space-y-3 pt-6 border-t border-[#2b8a8c]">
            @auth('client')
                <div class="px-4 py-3 bg-[#0a3536] text-white font-bold rounded-2xl text-center border border-[#2b8a8c] truncate">
                    {{ explode(' ', Auth::guard('client')->user()->full_name)[0] ?? 'Користувач' }}
                </div>
                <a href="{{ route('client.data') }}" class="block px-4 py-2.5 rounded-full text-base text-center bg-[#1a6668] text-cyan-100 btn-border font-bold">Мої дані</a>
                <a href="{{ route('client.actions') }}" class="block px-4 py-2.5 rounded-full text-base text-center bg-[#0a3536] hover:bg-[#0f3d3e] text-cyan-100 btn-border transition">Мої дії</a>
                <form action="{{ route('client.logout') }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 rounded-full text-sm text-center bg-red-600/30 hover:bg-red-600/50 text-red-200 border border-red-500/50 transition">Вийти</button>
                </form>
            @endauth
        </div>
    </nav>

    <!-- Основний контент -->
    <main class="flex-1 p-10 max-w-3xl mx-auto text-white">
        <h1 class="text-3xl font-bold mb-6">Особисті дані</h1>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/30 border border-green-500 text-green-200 rounded-2xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#1a6668] p-8 rounded-3xl shadow-xl border border-[#2b8a8c]">
            <form action="{{ route('client.data.update') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-cyan-200 mb-2 font-medium">Повне ім'я (ПІБ):</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $client->full_name) }}" required
                           class="w-full bg-[#0f3d3e] text-white px-4 py-3 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-cyan-200 mb-2 font-medium">Номер документа (Паспорт / ID):</label>
                        <input type="text" name="document_number" value="{{ old('document_number', $client->document_number) }}"
                               class="w-full bg-[#0f3d3e] text-white px-4 py-3 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
                    </div>
                    <div>
                        <label class="block text-cyan-200 mb-2 font-medium">Дата видачі:</label>
                        <input type="date" name="document_date" value="{{ old('document_date', $client->document_date) }}"
                               class="w-full bg-[#0f3d3e] text-white px-4 py-3 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
                    </div>
                </div>

                <div>
                    <label class="block text-cyan-200 mb-2 font-medium">Ким виданий документ:</label>
                    <input type="text" name="document_issued_by" value="{{ old('document_issued_by', $client->document_issued_by) }}"
                           class="w-full bg-[#0f3d3e] text-white px-4 py-3 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-cyan-200 mb-2 font-medium">Телефон:</label>
                        <input type="text" name="phone" value="{{ old('phone', $client->phone) }}"
                               class="w-full bg-[#0f3d3e] text-white px-4 py-3 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
                    </div>
                    <div>
                        <label class="block text-cyan-200 mb-2 font-medium">Ідентифікаційний код (РНОКПП):</label>
                        <input type="text" name="tax_id" value="{{ old('tax_id', $client->tax_id) }}"
                               class="w-full bg-[#0f3d3e] text-white px-4 py-3 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">
                    </div>
                </div>

                <div>
                    <label class="block text-cyan-200 mb-2 font-medium">Адреса проживання:</label>
                    <textarea name="address" rows="3"
                              class="w-full bg-[#0f3d3e] text-white px-4 py-3 rounded-xl border border-[#2b8a8c] focus:outline-none focus:border-cyan-400">{{ old('address', $client->address) }}</textarea>
                </div>

                <button type="submit" class="w-full py-3.5 bg-white text-[#1a6668] font-bold rounded-full hover:bg-cyan-100 transition btn-border text-lg shadow-lg">
                    Зберегти зміни
                </button>
            </form>
        </div>
    </main>

</body>
</html>