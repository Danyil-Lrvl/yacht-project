<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Yacht Club</title>
    <!-- Додаємо логотип як іконку сайту у вкладку браузера -->
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background-color: #0f3d3e; }
        .btn-border { border: 1px solid #2b8a8c; }

        /* Кастомний скролбар для головної сторінки */
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
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Ліве меню -->
    <nav class="w-64 bg-[#105657] text-white p-8 rounded-r-[3rem] sticky top-0 h-screen">
        <div class="flex items-center mb-10">
            <img src="{{ asset('images/main-logo.png') }}" alt="Logo" class="h-20 w-20 object-contain">
            <h2 class="text-2xl font-bold tracking-widest ml-4">Yacht Club</h2>
        </div>
        
        <!-- Кнопки: темніший фон, центрований текст, збільшений шрифт -->
        <ul class="space-y-4">
            <li><a href="{{ url('/') }}" class="block px-6 py-4 rounded-full text-xl text-center bg-[#0a3536] hover:bg-[#0f3d3e] btn-border transition">Головна</a></li>
            <li><a href="{{ url('/yachts/rent') }}" class="block px-6 py-4 rounded-full text-xl text-center bg-[#0a3536] hover:bg-[#0f3d3e] btn-border transition">Оренда</a></li>
            <li><a href="{{ url('/yachts/buy') }}" class="block px-6 py-4 rounded-full text-xl text-center bg-[#0a3536] hover:bg-[#0f3d3e] btn-border transition">Купити</a></li>
        </ul>
    </nav>

    <!-- Основний контент -->
    <main class="flex-1 p-10">
        
        @if(isset($yachts))
            <!-- Шапка сторінки з заголовком та фільтром за типом яхти -->
            <div class="flex justify-between items-center mb-10 max-w-5xl mx-auto px-4">
                <h1 class="text-4xl font-bold text-white text-center capitalize">
                    {{ isset($type) ? $type->name_type : (isset($typeName) ? $typeName : 'Яхти') }}
                </h1>
                
                <!-- Випадаючий список фільтрації за типом -->
                @if(isset($types))
                    <form method="GET" action="{{ url()->current() }}" class="flex items-center gap-3 bg-[#1a6668] px-4 py-2 rounded-2xl border border-[#2b8a8c]">
                        <label for="type_id" class="text-cyan-100 font-medium whitespace-nowrap">Тип яхти:</label>
                        
                        <select name="type_id" id="type_id" onchange="this.form.submit()" class="bg-[#0f3d3e] text-white px-4 py-2 rounded-xl border border-[#2b8a8c] focus:outline-none cursor-pointer">
                            <option value="">Усі типи</option>
                            @foreach($types as $t)
                                <option value="{{ $t->id_type }}" {{ isset($selectedType) && $selectedType == $t->id_type ? 'selected' : '' }}>
                                    {{ $t->name_type }}
                                </option>
                            @endforeach
                        </select>
                        
                        @if(isset($selectedType) && $selectedType != '')
                            <a href="{{ url()->current() }}" class="text-xs text-cyan-200 hover:text-white underline ml-1">Скинути</a>
                        @endif
                    </form>
                @endif
            </div>
            
            <div class="max-w-5xl mx-auto">
                @forelse ($yachts as $yacht)
                    <div class="bg-[#1a6668] p-6 rounded-3xl shadow-xl flex items-center gap-8 mb-6 border border-[#2b8a8c]">
                        <div class="w-1/3 h-40 bg-gray-300 rounded-2xl overflow-hidden">
                            <img src="{{ asset('images/' . ($yacht->type ? $yacht->type->image_path : 'default.jpg')) }}" 
                                 class="w-full h-full object-cover" 
                                 alt="{{ $yacht->name }}">
                        </div>
                        
                        <div class="w-2/3 text-white">
                            <h2 class="text-2xl font-bold">{{ $yacht->name }}</h2>
                            <p class="text-cyan-100 mt-2">{{ $yacht->short_description }}</p>
                            
                            <!-- Головний рядок: зліва все в один рядок, справа кнопка -->
                            <div class="flex items-center justify-between mt-4 w-full gap-4">
                                
                                <!-- Ліва частина: Ціна, Місця та Комплектація чітко в один рядок -->
                                <div class="flex items-center gap-3">
                                    
                                    <!-- Блок ціни -->
                                    <div class="px-4 py-2 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c] flex flex-col items-center justify-center whitespace-nowrap">
                                        @if(request()->is('*/rent'))
                                            <span class="text-xs text-cyan-200">Ціна за 1 день:</span>
                                            <span class="text-lg font-bold text-white">{{ number_format($yacht->price_rent, 0, '.', ' ') }} $</span>
                                        @else
                                            <span class="text-xs text-cyan-200">Вартість придбання:</span>
                                            <span class="text-lg font-bold text-white">{{ number_format($yacht->price_buy, 0, '.', ' ') }} $</span>
                                        @endif
                                    </div>

                                    <!-- Блок місць -->
                                    <div class="px-4 py-3 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c] whitespace-nowrap flex items-center">
                                        <span class="text-sm text-cyan-200">Місць:</span>
                                        <span class="text-lg font-bold text-green-400 ml-2">
                                            {{ $yacht->type ? $yacht->type->max_passengers : '—' }}
                                        </span>
                                    </div>

                                    <!-- Примітка / Комплектація тепер тут у рядку -->
                                    @if(!empty($yacht->comment))
                                        <div class="px-4 py-2 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c] flex flex-col items-center justify-center">
                                            @foreach(explode(',', $yacht->comment) as $line)
                                                <span class="text-sm font-bold text-white whitespace-nowrap">{{ trim($line) }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Кнопка Детальніше праворуч -->
                                <a href="{{ url('/yacht/' . $yacht->id . '/' . (request()->is('*/rent') ? 'rent' : 'buy')) }}" class="px-6 py-2.5 bg-white text-[#1a6668] font-bold rounded-full hover:bg-cyan-100 transition btn-border shrink-0">
                                    Детальніше
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-cyan-100 text-xl py-10 bg-[#1a6668] rounded-3xl border border-[#2b8a8c] max-w-5xl mx-auto">
                        За вибраним типом яхт не знайдено.
                    </div>
                @endforelse
            </div>
        @else
            <!-- Головна сторінка -->
            <div class="flex flex-col items-center px-4">
                <div class="w-full max-w-6xl mb-4 relative">
                    <img src="{{ asset('images/yacht-main.jpg') }}" alt="Nautilus Expedition" class="w-full h-auto rounded-3xl shadow-2xl border-4 border-[#1a6668]">
                    
                    <!-- Логотип піднятий вище -->
                    <div class="absolute top-2 right-6">
                        <img src="{{ asset('images/main-logo.png') }}" alt="Logo" class="h-40 w-40 object-contain drop-shadow-2xl">
                    </div>
                </div>

                <!-- Блок тексту "Про нас" -->
                <div class="bg-[#1a6668] p-8 rounded-3xl w-full max-w-6xl text-white shadow-2xl border border-[#2b8a8c] mt-6">
                    <h3 class="text-3xl font-bold mb-4 text-center">Про наш Yacht Club</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                      <p class="text-lg text-cyan-100 leading-relaxed">
                        Ми — команда професіоналів, закоханих у море та свободу. Наш клуб "Ocean Glide" пропонує унікальні можливості для дослідження світу під вітрилами. Наші судна "Наутілус" — це поєднання елегантності, безпеки та найвищого комфорту для вашої ідеальної подорожі.
                      </p>
                    <p class="text-lg text-cyan-100 leading-relaxed">
                        Ми беремо на себе всі турботи: від професійного технічного обслуговування до персонального супроводу. Обираючи нас, ви обираєте надійність, досвід та незабутні враження від кожної хвилі, яку ви підкорите разом із "Nautilus Expedition".
                    </p>
                </div>
            </div>
            </div>
        @endif
    </main>
</body>
</html>