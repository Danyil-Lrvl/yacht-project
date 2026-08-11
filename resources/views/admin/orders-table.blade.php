<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] mb-10">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Керування замовленнями (Оренда & Купівля)</h2>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-[#2b8a8c] text-cyan-300">
                    <th class="p-3">Тип</th>
                    <th class="p-3">Клієнт</th>
                    <th class="p-3">Яхта</th>
                    <th class="p-3">Сума</th>
                    <th class="p-3">Статус</th>
                    <th class="p-3">Дії адміна</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rents as $rent)
                <tr class="border-b border-[#2b8a8c]/50">
                    <td class="p-3 text-cyan-400 font-semibold">Оренда</td>
                    <td class="p-3">{{ $rent->full_name }}</td>
                    <td class="p-3">{{ $rent->yacht->name ?? '—' }}</td>
                    <td class="p-3">{{ $rent->amount }} $</td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            @if($rent->status == 'paid') bg-emerald-500 text-white 
                            @elseif($rent->status == 'cancelled') bg-rose-500 text-white 
                            @else bg-amber-500 text-[#0f3d3e] @endif">
                            {{ ucfirst($rent->status ?? 'pending') }}
                        </span>
                    </td>
                    <td class="p-3">
                        <form action="{{ route('admin.order.status') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="type" value="rent">
                            <input type="hidden" name="id" value="{{ $rent->id }}">
                            <button name="status" value="paid" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-xs font-bold">Оплачено</button>
                            <button name="status" value="cancelled" class="px-3 py-1 bg-rose-600 hover:bg-rose-500 rounded-lg text-xs font-bold">Анульовано</button>
                        </form>
                    </td>
                </tr>
                @endforeach

                @foreach($buys as $buy)
                <tr class="border-b border-[#2b8a8c]/50">
                    <td class="p-3 text-cyan-200 font-semibold">Купівля</td>
                    <td class="p-3">{{ $buy->full_name }}</td>
                    <td class="p-3">{{ $buy->yacht->name ?? '—' }}</td>
                    <td class="p-3">{{ $buy->amount }} $</td>
                    <td class="p-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold 
                            @if($buy->status == 'paid') bg-emerald-500 text-white 
                            @elseif($buy->status == 'cancelled') bg-rose-500 text-white 
                            @else bg-amber-500 text-[#0f3d3e] @endif">
                            {{ ucfirst($buy->status ?? 'pending') }}
                        </span>
                    </td>
                    <td class="p-3">
                        <form action="{{ route('admin.order.status') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="type" value="buy">
                            <input type="hidden" name="id" value="{{ $buy->id }}">
                            <button name="status" value="paid" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-500 rounded-lg text-xs font-bold">Оплачено</button>
                            <button name="status" value="cancelled" class="px-3 py-1 bg-rose-600 hover:bg-rose-500 rounded-lg text-xs font-bold">Анульовано</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>