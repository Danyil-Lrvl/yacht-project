<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Оренда {{ $yacht->name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/main-logo.png') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <style>
        body { background-color: #0f3d3e; }
        
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: #0f3d3e; }
        ::-webkit-scrollbar-thumb { background: #2b8a8c; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #06b6d4; }

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
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-end mb-4">
            @if(Auth::guard('client')->check())
                @include('account.dropdown-menu')
            @else
                <a href="{{ route('client.login.form') }}" class="px-4 py-2 bg-[#2b8a8c] hover:bg-cyan-600 text-white rounded-xl transition font-semibold">Вхід / Реєстрація</a>
            @endif
        </div>

        <div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c]">
            <a href="{{ url('/yacht/' . $yacht->id . '/rent') }}" class="inline-block mb-4 text-cyan-300 hover:text-white transition font-semibold">&larr; Повернутися</a>
            <h1 class="text-3xl font-bold mb-6 text-cyan-300">Оренда: {{ $yacht->name }}</h1>
            
            <form action="{{ route('yacht.rent.submit') }}" method="POST" id="rentForm">
                @csrf
                <input type="hidden" name="yacht_id" value="{{ $yacht->id }}">
                <input type="hidden" id="dailyPrice" value="{{ $yacht->price_rent }}">
                
                <!-- ПУНКТ БЕЗПЕКИ: передаємо початкову ціну для перевірки на сервері, чи не змінював її адмін -->
                <input type="hidden" name="initial_price_per_day" value="{{ $yacht->price_rent }}">

                @php
                    $client = Auth::guard('client')->user();
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block mb-2">Повне ім'я:</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $client->full_name ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                    <div>
                        <label class="block mb-2">Телефон:</label>
                        <input type="text" name="phone" value="{{ old('phone', $client->phone ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                    <div>
                        <label class="block mb-2">Номер документа:</label>
                        <input type="text" name="document_number" value="{{ old('document_number', $client->document_number ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                    <div>
                        <label class="block mb-2">Дата видачі:</label>
                        <input type="text" name="document_date" id="document_date" value="{{ old('document_date', $client->document_date ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block mb-2">Ким виданий:</label>
                        <input type="text" name="document_issued_by" value="{{ old('document_issued_by', $client->document_issued_by ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block mb-2">Адреса:</label>
                        <input type="text" name="address" value="{{ old('address', $client->address ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                    
                    <div>
                        <label class="block mb-2">Email:</label>
                        <input type="email" name="email" value="{{ old('email', $client->email ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                    <div>
                        <label class="block mb-2">ІПН (Tax ID):</label>
                        <input type="text" name="tax_id" value="{{ old('tax_id', $client->tax_id ?? '') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block mb-2">Дата початку:</label>
                        <input type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border @error('start_date') border-red-500 @else border-[#2b8a8c] @enderror text-white">
                        
                        @error('start_date')
                            <p class="text-red-400 text-sm mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block mb-2">Дата завершення:</label>
                        <input type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" required class="w-full p-3 rounded-xl bg-[#0f3d3e] border border-[#2b8a8c] text-white">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-cyan-300 font-bold">Орієнтовна сума ($):</label>
                    <input type="text" id="totalAmount" readonly class="w-full p-3 rounded-xl bg-[#0f3d3e] border-2 border-cyan-400 text-white font-bold text-xl" placeholder="Оберіть дати оренди">
                </div>

                <button type="submit" class="w-full py-4 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition">Подати заявку</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dailyPrice = parseFloat(document.getElementById('dailyPrice').value);
            const totalInput = document.getElementById('totalAmount');
            const flatpickrConfig = { dateFormat: "Y-m-d", disableMobile: true };

            flatpickr("#document_date", flatpickrConfig);
            const startPicker = flatpickr("#start_date", { ...flatpickrConfig, minDate: "today", onChange: calculate });
            const endPicker = flatpickr("#end_date", { ...flatpickrConfig, minDate: "today", onChange: calculate });

            fetch("{{ url('/yacht/booked-dates/' . $yacht->id) }}")
                .then(response => response.json())
                .then(disabledDates => {
                    startPicker.set('disable', disabledDates);
                    endPicker.set('disable', disabledDates);
                })
                .catch(error => console.error('Помилка завантаження дат:', error));

            function calculate() {
                const startVal = document.getElementById('start_date').value;
                const endVal = document.getElementById('end_date').value;
                
                if (startVal && endVal) {
                    const start = new Date(startVal);
                    const end = new Date(endVal);
                    if (end >= start) {
                        const diffTime = Math.abs(end - start);
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // Включаючи день початку
                        const total = diffDays * dailyPrice;
                        
                        totalInput.value = total + " $ (Розрахується на сервері)";
                    }
                }
            }
        });
    </script>
</body>
</html>