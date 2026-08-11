<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>{{ $yacht->name }} | Nautilus Expedition</title>
    <!-- Додаємо логотип як іконку сайту у вкладку браузера -->
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f3d3e; }
        
        /* Кастомний скролбар для всієї сторінки та галереї */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #0f3d3e;
        }
        ::-webkit-scrollbar-thumb {
            background: #2b8a8c;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #06b6d4;
        }

        .overflow-x-auto::-webkit-scrollbar { 
            height: 10px; 
            background-color: #0f3d3e; 
        }
        .overflow-x-auto::-webkit-scrollbar-thumb { 
            background-color: #2b8a8c; 
            border-radius: 10px; 
            border: 2px solid #0f3d3e; 
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover { 
            background-color: #3dc1c4; 
        }
    </style>
</head>
<body class="p-10">
    
    <div class="max-w-4xl mx-auto text-white">
        <!-- Кнопка назад -->
        <a href="{{ url('/') }}" class="text-cyan-300 hover:text-white mb-6 block">← На головну</a>
        
        <h1 class="text-4xl font-bold mb-6">{{ $yacht->name }}</h1>
        
        <!-- Прокрутка фото -->
        <div class="flex gap-4 overflow-x-auto pb-4 mb-8">
            <!-- Головне фото типу -->
            <img src="{{ asset('images/' . ($yacht->type->image_path ?? 'default.jpg')) }}" 
                 class="h-64 rounded-3xl border-4 border-[#1a6668]" alt="{{ $yacht->name }}">
            
            <!-- Додаткові фото з таблиці yacht_photos -->
            @if($yacht->type && $yacht->type->photos)
                @foreach($yacht->type->photos as $photo)
                    <img src="{{ asset('images/' . $photo->image_path) }}" 
                         class="h-64 rounded-3xl border-4 border-[#1a6668]">
                @endforeach
            @endif
        </div>

        <div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c]">
            
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4 text-cyan-300">Про цю яхту</h2>
                <p class="text-lg leading-relaxed mb-4 text-gray-200">
                    {{ $yacht->description }}
                </p>
                
                <h3 class="text-xl font-bold mb-3 text-cyan-300">Чому обирають цю модель:</h3>
                <ul class="list-disc list-inside text-gray-200 space-y-2">
                    <li><strong>Надійність:</strong> Перевірена конструкція для далеких переходів.</li>
                    <li><strong>Комфорт:</strong> Спеціальна конструкція дверей.</li>
                    <li><strong>Автономність:</strong> Оптимізована система енергоспоживання.</li>
                </ul>
            </div>
            
            <div class="mb-6 pb-6 border-b border-[#2b8a8c]">
                <h2 class="text-xl font-bold mb-3">Характеристики:</h2>
                
                @if($yacht->type)
                    <div class="grid grid-cols-2 gap-4">
                        <p>Довжина: <strong>{{ $yacht->type->length ?? '—' }}</strong></p>
                        <p>Ширина: <strong>{{ $yacht->type->width ?? '—' }}</strong></p>
                        <p>Каюти: <strong>{{ $yacht->type->cabins ?? '—' }}</strong></p>
                        <p>Гальюни: <strong>{{ $yacht->type->heads ?? '—' }}</strong></p>
                        <p>Двигун: <strong>{{ $yacht->type->engine_model ?? '—' }}</strong></p>
                        <p>Рік: <strong>{{ $yacht->type->year ?? '—' }}</strong></p>
                    </div>
                @else
                    <p class="text-gray-400 italic">Характеристики не вказані.</p>
                @endif
            </div>

            <!-- Кнопка дії та динамічна ціна -->
            <div class="flex items-center justify-between pt-2">
                <span class="text-3xl font-bold">
                    @if($type == 'rent')
                        {{ number_format($yacht->price_rent, 0, '.', ' ') }} $
                        <span class="text-lg font-normal">за 1 день</span>
                    @else
                        {{ number_format($yacht->price_buy, 0, '.', ' ') }} $
                    @endif
                </span>
                
                @if($type == 'rent')
                    <a href="{{ url('/yacht/rent/' . $yacht->id) }}" class="px-8 py-3 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300">Орендувати</a>
                @else
                    <a href="{{ url('/yacht/buy/' . $yacht->id) }}" class="px-8 py-3 bg-white text-[#1a6668] font-bold rounded-full hover:bg-gray-200">Купити</a>
                @endif
            </div>
        </div>
    </div>
</body>
</html>