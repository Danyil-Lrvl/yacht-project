<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Купівля {{ $yacht->name }}</title>
    <!-- Додаємо логотип як іконку сайту у вкладку браузера -->
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <style>
        body { background-color: #0f3d3e; }
        
        /* Кастомний скролбар для темної теми сайту */
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

        .flatpickr-calendar { background: #1a6668 !important; border: 1px solid #2b8a8c !important; color: #ffffff !important; }
        .flatpickr-weekday, .flatpickr-day { color: #ffffff !important; }
        .flatpickr-current-month, .flatpickr-monthDropdown-month { color: #ffffff !important; font-weight: bold; }
        
        .flatpickr-day.disabled, 
        .flatpickr-day.flatpickr-disabled, 
        .flatpickr-day.flatpickr-disabled:hover { 
            color: #5a7d7e !important; 
            background: #0f3d3e !important; 
            cursor: not-allowed !important;
            background-image: linear-gradient(135deg, transparent 48%, #5a7d7e 50%, #5a7d7e 52%, transparent 54%) !important;
        }
        
        .flatpickr-day.selected { background: #06b6d4 !important; color: white !important; }
        .flatpickr-day.selected:hover { background: #06b6d4 !important; }
        .flatpickr-day:hover:not(.flatpickr-disabled) { background: #2b8a8c !important; }
        .flatpickr-prev-month svg, .flatpickr-next-month svg { fill: #ffffff !important; }
    </style>
</head>
<body class="p-10 text-white">
    <div class="max-w-3xl mx-auto bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c]">
        
        <a href="{{ url('/yacht/' . $yacht->id . '/buy') }}" class="inline-block mb-4 text-cyan-300 hover:text-white transition font-semibold">
            &larr; Повернутися
        </a>

        <h1 class="text-3xl font-bold mb-6 text-cyan-300">Заявка на купівлю: {{ $yacht->name }}</h1>
        
        <form action="{{ route('yacht.buy.submit') }}" method="POST">
            @csrf
            <input type="hidden" name="yacht_id" value="{{ $yacht->id }}">

            <!-- Блок даних клієнта (структура як на оренді) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block mb-2">Повне ім'я:</label>
                    <input type="text" name="full_name" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
                <div>
                    <label class="block mb-2">Телефон:</label>
                    <input type="text" name="phone" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
                <div>
                    <label class="block mb-2">Номер документа:</label>
                    <input type="text" name="document_number" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
                <div>
                    <label class="block mb-2">Дата видачі:</label>
                    <input type="text" name="document_date" id="document_date" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
                
                <div class="md:col-span-2">
                    <label class="block mb-2">Ким виданий:</label>
                    <input type="text" name="document_issued_by" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-2">Адреса:</label>
                    <input type="text" name="address" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
                
                <div>
                    <label class="block mb-2">Email:</label>
                    <input type="email" name="email" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
                <div>
                    <label class="block mb-2">ІПН (Tax ID):</label>
                    <input type="text" name="tax_id" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                </div>
            </div>

            <div class="mb-6">
                <label class="block mb-2 text-cyan-300 font-bold">Ціна яхти ($):</label>
                <input type="number" name="amount" value="{{ $yacht->price_buy }}" readonly class="w-full p-3 rounded-xl bg-[#0f3d3e] border-2 border-cyan-400 text-white font-bold text-xl">
            </div>

            <button type="submit" class="w-full py-4 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition">
                Відправити заявку на купівлю
            </button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            flatpickr("#document_date", { 
                dateFormat: "Y-m-d", 
                disableMobile: true 
            });
        });
    </script>
</body>
</html>