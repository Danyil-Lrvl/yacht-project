<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Історія замовлень — Yacht Club</title>
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
                <!-- ІМ'Я КОРИСТУВАЧА З ПРЕФІКСОМ -->
        <div class="text-xl font-bold mb-6 text-center text-white">
         Ім'я: {{ explode(' ', Auth::guard('client')->user()->full_name)[0] ?? 'Користувач' }}
        </div>
    
     <a href="{{ route('client.data') }}" class="block px-4 py-2.5 rounded-full text-base text-center bg-[#0a3536] hover:bg-[#0f3d3e] text-cyan-100 btn-border transition">Особисті дані</a>
     <a href="{{ route('client.actions') }}" class="block px-4 py-2.5 rounded-full text-base text-center bg-[#1a6668] text-cyan-100 btn-border font-bold">Історія замовлень</a>
    
        <form action="{{ route('client.logout') }}" method="POST" class="mt-2">
        @csrf
        <button type="submit" class="w-full px-4 py-2 rounded-full text-sm text-center bg-red-600/30 hover:bg-red-600/50 text-red-200 border border-red-500/50 transition">Вийти</button>
     </form>
            @endauth
        </div>
        </nav>

    <!-- Основний контент -->
    <main class="flex-1 p-10 max-w-5xl mx-auto text-white">
        <h1 class="text-3xl font-bold mb-2">Історія замовлень</h1>
        <h4 class="text-cyan-200 mb-6 text-sm">Користувач: {{ $client->full_name ?? $client->email }}</h4>

        <!-- Блок оренди -->
        <div class="bg-[#1a6668] p-6 rounded-3xl shadow-xl border border-[#2b8a8c] mb-8">
            <h3 class="text-2xl font-bold mb-4 text-cyan-200">Оренди</h3>
            @if(isset($rents) && count($rents) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#2b8a8c] text-cyan-100">
                                <th class="py-3 px-4">Яхта</th>
                                <th class="py-3 px-4">Період оренди</th>
                                <th class="py-3 px-4">Сума</th>
                                <th class="py-3 px-4">Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rents as $rent)
                            @php
                                $status = strtolower($rent->status ?? 'pending');
                                if (in_array($status, ['cancelled', 'анульовано'])) {
                                    $displayStatus = 'анульовано';
                                    $badgeClass = 'bg-red-500/35 text-red-200 border border-red-500';
                                } elseif (in_array($status, ['paid', 'оплачено'])) {
                                    $displayStatus = 'оплачено';
                                    $badgeClass = 'bg-emerald-500/35 text-emerald-200 border border-emerald-500';
                                } else {
                                    $displayStatus = 'заявка';
                                    $badgeClass = 'bg-amber-500/35 text-amber-200 border border-amber-500';
                                }
                            @endphp
                            <tr class="border-b border-[#2b8a8c]/50">
                                <td class="py-3 px-4 font-semibold">{{ $rent->yacht->name ?? 'Яхта' }}</td>
                                <td class="py-3 px-4">{{ $rent->start_date }} — {{ $rent->end_date }}</td>
                                <td class="py-3 px-4">{{ $rent->amount }} $</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                        {{ $displayStatus }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-cyan-100">У вас поки немає активних чи минулих оренд.</p>
            @endif
        </div>

        <!-- Блок покупок -->
        <div class="bg-[#1a6668] p-6 rounded-3xl shadow-xl border border-[#2b8a8c]">
            <h3 class="text-2xl font-bold mb-4 text-cyan-200">Покупки</h3>
            @if(isset($sales) && count($sales) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#2b8a8c] text-cyan-100">
                                <th class="py-3 px-4">Яхта</th>
                                <th class="py-3 px-4">Дата покупки</th>
                                <th class="py-3 px-4">Сума</th>
                                <th class="py-3 px-4">Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                            @php
                                $statusBuy = strtolower($sale->status ?? 'pending');
                                if (in_array($statusBuy, ['cancelled', 'анульовано'])) {
                                    $displayStatusBuy = 'анульовано';
                                    $badgeClassBuy = 'bg-red-500/35 text-red-200 border border-red-500';
                                } elseif (in_array($statusBuy, ['paid', 'оплачено'])) {
                                    $displayStatusBuy = 'оплачено';
                                    $badgeClassBuy = 'bg-emerald-500/35 text-emerald-200 border border-emerald-500';
                                } else {
                                    $displayStatusBuy = 'заявка';
                                    $badgeClassBuy = 'bg-amber-500/35 text-amber-200 border border-amber-500';
                                }
                            @endphp
                            <tr class="border-b border-[#2b8a8c]/50">
                                <td class="py-3 px-4 font-semibold">{{ $sale->yacht->name ?? 'Яхта' }}</td>
                                <td class="py-3 px-4">{{ $sale->sale_date ?? $sale->created_at->format('Y-m-d') }}</td>
                                <td class="py-3 px-4">{{ $sale->amount }} $</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $badgeClassBuy }}">
                                        {{ $displayStatusBuy }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-cyan-100">У вас поки немає історії покупок.</p>
            @endif
        </div>
    </main>

</body>
</html>