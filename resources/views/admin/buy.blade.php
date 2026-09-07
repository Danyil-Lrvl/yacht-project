@extends('admin.layout')

@section('title', 'Керування продажем | Адмін-панель')

@section('content')
<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] mb-10">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Керування замовленнями (Продаж)</h2>
    
    <!-- Фільтри -->
    <form method="GET" action="{{ route('admin.buy') }}" class="flex gap-4 mb-6 items-center flex-wrap">
        <div>
            <label class="block text-xs text-cyan-200 mb-1">Дата подачі:</label>
            <div class="flex gap-2">
                <input type="date" name="date" value="{{ request('date') }}" class="p-2 rounded-lg bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                <button type="submit" name="last_7_days" value="1" class="px-3 py-2 bg-[#1d5f64] hover:bg-[#2b8a8c] text-cyan-200 text-xs font-bold rounded-lg transition border border-[#2b8a8c]">За останні 7 днів</button>
            </div>
        </div>
        <div>
            <label class="block text-xs text-cyan-200 mb-1">Статус:</label>
            <select name="status" class="p-2 rounded-lg bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                <option value="">Всі статуси</option>
                <option value="заявка" {{ request('status') == 'заявка' ? 'selected' : '' }}>Заявка</option>
                <option value="оплачено" {{ request('status') == 'оплачено' ? 'selected' : '' }}>Оплачено</option>
                <option value="анульовано" {{ request('status') == 'анульовано' ? 'selected' : '' }}>Анульовано</option>
            </select>
        </div>
        <div class="self-end flex gap-2">
            <button type="submit" class="px-4 py-2 bg-cyan-500 hover:bg-cyan-400 text-[#0b3c40] font-bold rounded-lg">Фільтрувати</button>
            <a href="{{ route('admin.buy') }}" class="px-4 py-2 bg-[#1d5f64] text-white rounded-lg">Скинути</a>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-[#2b8a8c] text-cyan-300">
                    <th class="p-3">Дата заявки</th>
                    <th class="p-3">Клієнт (ПІБ, тел, email)</th>
                    <th class="p-3">Яхта</th>
                    <th class="p-3">Сума</th>
                    <th class="p-3">Статус</th>
                    <th class="p-3">Дії адміна</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buys as $buy)
                @php
                    $statusMapBuy = [
                        'cancelled' => 'анульовано', 'Cancelled' => 'анульовано', 'анульовано' => 'анульовано',
                        'paid' => 'оплачено', 'оплачено' => 'оплачено',
                        'pending' => 'заявка', 'заявка' => 'заявка',
                    ];
                    $rawStatusBuy = strtolower($buy->status ?? 'pending');
                    $displayStatusBuy = $statusMapBuy[$rawStatusBuy] ?? ucfirst($buy->status);
                @endphp
                <tr class="border-b border-[#2b8a8c]/50">
                    <td class="p-3 text-cyan-200">{{ $buy->created_date ?? $buy->created_at->toDateString() }}</td>
                    <td class="p-3">
                        <details class="cursor-pointer">
                            <summary class="font-semibold text-white hover:text-cyan-300">{{ $buy->client->full_name ?? 'Клієнт не знайдений' }}</summary>
                            <div class="mt-2 p-2 bg-[#0f3d3e] rounded-lg text-xs space-y-1 border border-[#2b8a8c]">
                                <p><strong>ПІБ:</strong> {{ $buy->client->full_name ?? '—' }}</p>
                                <p><strong>Телефон:</strong> {{ $buy->client->phone ?? '—' }}</p>
                                <p><strong>Email:</strong> {{ $buy->client->email ?? '—' }}</p>
                            </div>
                        </details>
                    </td>
                    <td class="p-3">{{ $buy->yacht->name ?? '—' }}</td>
                    <td class="p-3">{{ $buy->amount }} $</td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            @if(in_array($rawStatusBuy, ['paid', 'оплачено'])) bg-emerald-500 text-white 
                            @elseif(in_array($rawStatusBuy, ['cancelled', 'анульовано'])) bg-rose-500 text-white 
                            @else bg-amber-500 text-[#0f3d3e] @endif">
                            {{ $displayStatusBuy }}
                        </span>
                    </td>
                    <td class="p-3">
                        <form action="{{ route('admin.order.status') }}" method="POST" class="flex gap-1 flex-wrap">
                            @csrf
                            <input type="hidden" name="type" value="buy">
                            <input type="hidden" name="id" value="{{ $buy->id }}">
                            <button name="status" value="заявка" class="px-2 py-1 bg-amber-600 hover:bg-amber-500 rounded-lg text-xs font-bold">Заявка</button>
                            <button name="status" value="оплачено" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-xs font-bold">Оплачено</button>
                            <button name="status" value="анульовано" class="px-2 py-1 bg-rose-600 hover:bg-rose-500 rounded-lg text-xs font-bold">Анульовано</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection