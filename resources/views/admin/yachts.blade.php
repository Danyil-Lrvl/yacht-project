@extends('admin.layout')

@section('title', 'Екземпляри яхти | Адмін-панель')

@section('content')
<!-- Форма додавання нового екземпляра -->
<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] mb-10">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Додати екземпляр яхти (yachts)</h2>
    <form action="{{ route('admin.yacht.store') }}" method="POST">
        @csrf
        <div class="p-4 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c]">
            
            <!-- Поле для введення імені/назви яхти -->
            <div class="mb-4">
                <label class="block mb-2 text-sm">Назва яхти:</label>
                <input type="text" name="name" placeholder='напр:Nordhavn 42 - "Марія"' required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm">Оберіть тип яхти:</label>
                    <select name="type_id" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                        @foreach($types ?? [] as $t)
                            <option value="{{ $t->id_type ?? $t->id }}">{{ $t->name_type }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-sm">Серійний номер (serial_number):</label>
                    <input type="text" name="serial_number" placeholder="NH42-00000" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div><label class="block mb-2 text-xs">Рік випуску:</label><input type="number" name="year" value="2026" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Ціна оренди ($):</label><input type="number" step="0.01" name="price_rent" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Ціна покупки ($):</label><input type="number" step="0.01" name="price_buy" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div>
                    <label class="block mb-2 text-xs">Операція:</label>
                    <select name="type_oper" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                        <option value="rent">rent (оренда)</option>
                        <option value="buy">buy (купівля)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div><label class="block mb-2 text-sm">Останнє обслуговування:</label><input type="text" name="last_maintenance" value="{{ date('Y-m-d') }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-sm">Дата реєстрації:</label><input type="text" name="registration_date" value="{{ date('Y-m-d') }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div>
                    <label class="block mb-2 text-sm">Активність:</label>
                    <select name="is_active" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                        <option value="1">Активна (1)</option>
                        <option value="0">Неактивна (0)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block mb-2 text-sm">Коментар:</label>
                <input type="text" name="comment" value="Стандартна комплектація" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
        </div>
        <button type="submit" class="mt-6 w-full py-4 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition text-lg">Зберегти екземпляр яхти</button>
    </form>
</div>

<!-- Блок фільтрації екземплярів яхт -->
<div class="bg-[#1a6668] p-6 rounded-3xl border border-[#2b8a8c] mb-10">
    <h3 class="text-xl font-bold mb-4 text-cyan-300">Фільтрація екземплярів яхт</h3>
    <form method="GET" action="{{ route('admin.yachts') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div>
            <label class="block mb-1 text-xs">Пошук за серійним номером:</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="напр. NH42" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
        </div>
        <div>
            <label class="block mb-1 text-xs">Тип операції (type_oper):</label>
            <select name="type_oper" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                <option value="">Усі операції</option>
                <option value="rent" {{ request('type_oper') == 'rent' ? 'selected' : '' }}>Оренда (rent)</option>
                <option value="buy" {{ request('type_oper') == 'buy' ? 'selected' : '' }}>Купівля (buy)</option>
            </select>
        </div>
        <div>
            <label class="block mb-1 text-xs">Конкретний тип яхти:</label>
            <select name="type_id" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                <option value="">Усі типи</option>
                @foreach($types ?? [] as $t)
                    <option value="{{ $t->id_type ?? $t->id }}" {{ request('type_id') == ($t->id_type ?? $t->id) ? 'selected' : '' }}>{{ $t->name_type }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 text-xs">Період додавання:</label>
            <select name="last_7_days" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#0f3d3e] text-white">
                <option value="">Усі записи</option>
                <option value="1" {{ request('last_7_days') ? 'selected' : '' }}>За останні 7 днів</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="w-full py-2.5 bg-cyan-400 text-[#0f3d3e] font-bold rounded-xl hover:bg-cyan-300 transition">Фільтрувати</button>
            <a href="{{ route('admin.yachts') }}" class="py-2.5 px-4 bg-rose-600/80 text-white rounded-xl hover:bg-rose-500 transition text-center">Скинути</a>
        </div>
    </form>
</div>

<!-- Редагування існуючих яхт -->
<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c]">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Редагування екземплярів яхт</h2>
    @forelse($yachts ?? [] as $yacht)
    <form action="{{ route('admin.yacht.update', $yacht->id) }}" method="POST" class="mb-6 p-6 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c]">
        @csrf
        @method('PUT')
        
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#2b8a8c]">
            <div>
                <span class="text-cyan-300 font-bold text-lg">
                    {{ $yacht->name ?? 'Яхта без назви' }}
                </span>
                <div class="text-xs text-cyan-200/70 mt-0.5">
                    ID: <span class="text-white font-semibold">{{ $yacht->id }}</span>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-sm">Назва яхти:</label>
            <input type="text" name="name" value="{{ $yacht->name }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-sm">Тип яхти:</label>
                <select name="type_id" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                    @foreach($types ?? [] as $t)
                        <option value="{{ $t->id_type ?? $t->id }}" {{ ($yacht->type_id) == ($t->id_type ?? $t->id) ? 'selected' : '' }}>
                            {{ $t->name_type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-2 text-sm">Серійний номер:</label>
                <input type="text" name="serial_number" value="{{ $yacht->serial_number ?? $yacht->serial ?? '' }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
            <div>
                <label class="block mb-2 text-sm">Рік випуску:</label>
                <input type="number" name="year" value="{{ $yacht->year }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-xs">Ціна оренди ($):</label>
                <input type="number" step="0.01" name="price_rent" value="{{ $yacht->price_rent }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
            <div>
                <label class="block mb-2 text-xs">Ціна покупки ($):</label>
                <input type="number" step="0.01" name="price_buy" value="{{ $yacht->price_buy }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
            <div>
                <label class="block mb-2 text-xs">Тип операції:</label>
                <select name="type_oper" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                    <option value="rent" {{ $yacht->type_oper == 'rent' ? 'selected' : '' }}>Оренда (rent)</option>
                    <option value="buy" {{ $yacht->type_oper == 'buy' ? 'selected' : '' }}>Купівля (buy)</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-xs">Активність:</label>
                <select name="is_active" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                    <option value="1" {{ $yacht->is_active == 1 ? 'selected' : '' }}>Активна (1)</option>
                    <option value="0" {{ $yacht->is_active == 0 ? 'selected' : '' }}>Неактивна (0)</option>
                </select>
            </div>
            <div>
                <label class="block mb-2 text-xs">Коментар:</label>
                <input type="text" name="comment" value="{{ $yacht->comment }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
        </div>

        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 rounded-xl text-white font-bold text-sm">Оновити яхту</button>
    </form>
    @empty
    <p class="text-cyan-200 text-center py-4">Екземплярів яхт не знайдено</p>
    @endforelse
</div>
@endsection