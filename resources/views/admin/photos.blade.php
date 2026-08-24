@extends('admin.layout')

@section('title', 'Фотографії яхт | Адмін-панель')

@section('content')
<!-- Форма завантаження нових фото (прив'язка до типу яхти) -->
<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] mb-10">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Додаткові фотографії (yacht_photos)</h2>
    <form action="{{ route('admin.photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="p-4 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c] mb-6">
            <div class="mb-4">
                <label class="block mb-2 text-sm">Оберіть тип яхти для фото:</label>
                <select name="type_id" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                    <option value="">-- Оберіть тип яхти --</option>
                    @foreach($types ?? [] as $t)
                        <option value="{{ $t->id_type ?? $t->id }}">
                            {{ $t->name_type ?? $t->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><label class="block mb-2 text-sm">Фото 1:</label><input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white"></div>
                <div><label class="block mb-2 text-sm">Фото 2:</label><input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white"></div>
                <div><label class="block mb-2 text-sm">Фото 3:</label><input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white"></div>
                <div><label class="block mb-2 text-sm">Фото 4:</label><input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white"></div>
            </div>
        </div>
        <button type="submit" class="w-full py-4 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition text-lg">Зберегти фотографії</button>
    </form>
</div>

<!-- Блок фільтрації фотографій -->
<div class="bg-[#1a6668] p-6 rounded-3xl border border-[#2b8a8c] mb-10">
    <h3 class="text-xl font-bold mb-4 text-cyan-300">Фільтрація фотографій</h3>
    <form method="GET" action="{{ route('admin.photos') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block mb-1 text-xs">Фільтр за типом яхти:</label>
            <select name="type_id" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                <option value="">Усі типи</option>
                @foreach($types ?? [] as $t)
                    <option value="{{ $t->id_type ?? $t->id }}" {{ request('type_id') == ($t->id_type ?? $t->id) ? 'selected' : '' }}>
                        {{ $t->name_type ?? $t->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1 text-xs">Період завантаження:</label>
            <select name="last_7_days" class="w-full p-2.5 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                <option value="">Усі записи</option>
                <option value="1" {{ request('last_7_days') ? 'selected' : '' }}>За останні 7 днів</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="w-full py-2.5 bg-cyan-400 text-[#0f3d3e] font-bold rounded-xl hover:bg-cyan-300 transition">Фільтрувати</button>
            <a href="{{ route('admin.photos') }}" class="py-2.5 px-4 bg-rose-600/80 text-white rounded-xl hover:bg-rose-500 transition text-center">Скинути</a>
        </div>
    </form>
</div>

<!-- Список і керування існуючими фото -->
<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c]">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Керування існуючими фото</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($photos ?? [] as $photo)
        <div class="p-4 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c] flex flex-col justify-between">
            <div>
                <!-- Виправлено шлях до зображення на такий самий, як на публічній сторінці -->
                <img src="{{ asset('images/' . $photo->image_path) }}" alt="Фото яхти" class="w-full h-40 object-cover rounded-xl mb-3 border border-[#2b8a8c]">
                <p class="text-xs text-cyan-300 mb-3 text-center truncate" title="{{ basename($photo->image_path) }}">
                    Файл: <span class="font-bold text-white">{{ basename($photo->image_path) }}</span>
                </p>
            </div>

            <!-- Форма заміни та видалення фото -->
            <div class="space-y-2">
                <form action="{{ route('admin.photos.update', $photo->id ?? $photo->id_photo) }}" method="POST" enctype="multipart/form-data" class="flex gap-2">
                    @csrf
                    @method('PUT')
                    <input type="file" name="image" required class="hidden" id="photo-input-{{ $photo->id ?? $photo->id_photo }}" onchange="this.form.submit()">
                    <label for="photo-input-{{ $photo->id ?? $photo->id_photo }}" class="w-full py-2 bg-amber-600 hover:bg-amber-500 rounded-xl text-white font-bold text-sm text-center cursor-pointer transition">
                        Змінити
                    </label>
                </form>

                <form action="{{ route('admin.photos.destroy', $photo->id ?? $photo->id_photo) }}" method="POST" class="w-full">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-2 bg-rose-600 hover:bg-rose-500 rounded-xl text-white font-bold text-sm transition">Видалити фото</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-cyan-200 text-center col-span-3 py-4">Фотографій не знайдено</p>
        @endforelse
    </div>
</div>
@endsection