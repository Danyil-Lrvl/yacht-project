@extends('admin.layout')

@section('title', 'Типи яхт | Адмін-панель')

@section('content')
<!-- Форма додавання нового типу -->
<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] mb-10">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Додати новий тип яхти (type_yachts)</h2>
    <form action="{{ route('admin.type.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="p-4 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm">Назва типу (name_type):</label>
                    <input type="text" name="name_type" placeholder="напр. Nordhavn 42" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white placeholder-cyan-200/50">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Рік моделі типу (year):</label>
                    <input type="number" name="year" min="1900" max="2100" required value="2026" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div><label class="block mb-2 text-xs">Довжина (length):</label><input type="text" name="length" placeholder="ft" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Ширина (width):</label><input type="text" name="width" placeholder="ft" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Пасажири (max_passengers):</label><input type="number" name="max_passengers" min="0" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Каюти (cabins):</label><input type="number" name="cabins" min="0" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Гальюни (heads):</label><input type="number" name="heads" min="0" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Потужність (engine_power):</label><input type="text" name="engine_power" placeholder="hp" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Двигун (engine_model):</label><input type="text" name="engine_model" value="Lugger" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Стан (condition):</label><input type="text" name="condition" value="New" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm">Короткий опис:</label>
                    <textarea name="short_description" rows="2" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></textarea>
                </div>
                <div>
                    <label class="block mb-2 text-sm">Повний опис:</label>
                    <textarea name="full_description" rows="2" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></textarea>
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-2 text-sm font-bold text-cyan-300">Основне фото (image_path):</label>
                <input type="file" name="type_image" class="w-full p-2.5 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white">
            </div>
        </div>

        <button type="submit" class="mt-6 w-full py-4 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition text-lg">Зберегти новий тип</button>
    </form>
</div>

<!-- Блок фільтрації типів -->
<div class="bg-[#1a6668] p-6 rounded-3xl border border-[#2b8a8c] mb-10">
    <h3 class="text-xl font-bold mb-4 text-cyan-300">Фільтрація типів яхт</h3>
    <form method="GET" action="{{ route('admin.types') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block mb-1 text-xs">Пошук за назвою:</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="напр. Nordhavn" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
        </div>
        <div>
            <label class="block mb-1 text-xs">Стан (condition):</label>
            <input type="text" name="condition" value="{{ request('condition') }}" placeholder="напр. New" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
        </div>
        <div>
            <label class="block mb-1 text-xs">Період додавання:</label>
            <select name="last_7_days" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                <option value="">Усі записи</option>
                <option value="1" {{ request('last_7_days') ? 'selected' : '' }}>За останні 7 днів</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="w-full py-2.5 bg-cyan-400 text-[#0f3d3e] font-bold rounded-xl hover:bg-cyan-300 transition">Фільтрувати</button>
            <a href="{{ route('admin.types') }}" class="py-2.5 px-4 bg-rose-600/80 text-white rounded-xl hover:bg-rose-500 transition text-center">Скинути</a>
        </div>
    </form>
</div>

<!-- Список і повне редагування існуючих типів -->
<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c]">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Редагування існуючих типів (повний вміст)</h2>
    @forelse($types ?? [] as $type)
    <form action="{{ route('admin.type.update', $type->id_type) }}" method="POST" enctype="multipart/form-data" class="mb-6 p-6 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c]">
        @csrf
        @method('PUT')
        
        <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#2b8a8c]">
            <span class="text-cyan-300 font-bold">ID типу: {{ $type->id_type }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-sm">Назва типу (name_type):</label>
                <input type="text" name="name_type" value="{{ $type->name_type }}" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
            <div>
                <label class="block mb-2 text-sm">Рік (year):</label>
                <input type="number" name="year" value="{{ $type->year }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div><label class="block mb-2 text-xs">Довжина:</label><input type="text" name="length" value="{{ $type->length }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            <div><label class="block mb-2 text-xs">Ширина:</label><input type="text" name="width" value="{{ $type->width }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            <div><label class="block mb-2 text-xs">Пасажири:</label><input type="number" name="max_passengers" value="{{ $type->max_passengers }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            <div><label class="block mb-2 text-xs">Каюти:</label><input type="number" name="cabins" value="{{ $type->cabins }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            <div><label class="block mb-2 text-xs">Гальюни:</label><input type="number" name="heads" value="{{ $type->heads }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            <div><label class="block mb-2 text-xs">Потужність двигуна:</label><input type="text" name="engine_power" value="{{ $type->engine_power }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            <div><label class="block mb-2 text-xs">Модель двигуна:</label><input type="text" name="engine_model" value="{{ $type->engine_model }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            <div><label class="block mb-2 text-xs">Стан:</label><input type="text" name="condition" value="{{ $type->condition }}" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block mb-2 text-sm">Короткий опис:</label>
                <textarea name="short_description" rows="2" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">{{ $type->short_description }}</textarea>
            </div>
            <div>
                <label class="block mb-2 text-sm">Повний опис:</label>
                <textarea name="full_description" rows="2" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">{{ $type->full_description }}</textarea>
            </div>
        </div>

        <!-- Блок "Основне фото" внизу форми редагування -->
        <div class="p-4 bg-[#1a6668] rounded-2xl border border-[#2b8a8c] mb-4 flex flex-col md:flex-row items-center gap-4">
            @if(!empty($type->image_path))
                <div class="shrink-0">
                    <span class="block mb-1 text-xs text-cyan-200">Поточне фото:</span>
                    
                    @php
                        // Якщо в базі шлях починається з 'images/', прибираємо його, бо далі додаємо загальний префікс 'images/'
                        $cleanImageName = Str::startsWith($type->image_path, 'images/') 
                            ? Str::after($type->image_path, 'images/') 
                            : $type->image_path;
                    @endphp

                    <img src="{{ asset('images/' . $cleanImageName) }}" alt="Основне фото" class="w-24 h-16 object-cover rounded-xl border border-[#2b8a8c]">
                </div>
            @endif
            <div class="w-full">
                <label class="block mb-2 text-sm font-bold text-cyan-300">Основне фото (завантажити нове для заміни):</label>
                <input type="file" name="type_image" class="w-full p-2.5 bg-[#0f3d3e] border border-[#2b8a8c] rounded-xl text-white">
            </div>
        </div>

        <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-500 rounded-xl text-white font-bold text-sm">Оновити тип</button>
    </form>
    @empty
    <p class="text-cyan-200 text-center py-4">Типів яхт не знайдено</p>
    @endforelse
</div>
@endsection