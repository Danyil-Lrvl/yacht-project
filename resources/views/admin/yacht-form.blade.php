<div class="bg-[#1a6668] p-8 rounded-3xl border border-[#2b8a8c] mb-10">
    <h2 class="text-2xl font-bold mb-6 text-cyan-300">Додати нову яхту та її тип</h2>
    <form action="{{ route('admin.yacht.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Частина 1: Характеристики типу яхти (type_yachts) -->
        <div class="mb-6 p-4 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c]">
            <h3 class="text-lg font-bold mb-4 text-cyan-400">1. Характеристики типу яхти (type_yachts)</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm">Назва типу (name_type):</label>
                    <input type="text" name="name_type" placeholder="напр. Nordhavn 42" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white placeholder-cyan-200/50">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Рік моделі типу (year):</label>
                    <input type="number" name="type_year" min="1900" max="2100" required value="2026" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                <div><label class="block mb-2 text-xs">Довжина (length):</label><input type="text" name="length" placeholder="ft" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white placeholder-cyan-200/50"></div>
                <div><label class="block mb-2 text-xs">Ширина (width):</label><input type="text" name="width" placeholder="ft" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white placeholder-cyan-200/50"></div>
                <div><label class="block mb-2 text-xs">Пасажири (max_passengers):</label><input type="number" name="max_passengers" min="0" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Каюти (cabins):</label><input type="number" name="cabins" min="0" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Гальюни (heads):</label><input type="number" name="heads" min="0" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Потужність (engine_power):</label><input type="text" name="engine_power" placeholder="hp" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white placeholder-cyan-200/50"></div>
                <div><label class="block mb-2 text-xs">Двигун (engine_model):</label><input type="text" name="engine_model" value="Lugger" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
                <div><label class="block mb-2 text-xs">Стан (condition):</label><input type="text" name="condition" value="New" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm">Короткий опис (short_description):</label>
                    <textarea name="short_description" rows="2" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></textarea>
                </div>
                <div>
                    <label class="block mb-2 text-sm">Повний опис (full_description):</label>
                    <textarea name="full_description" rows="2" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white"></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm">Головне фото типу (image_path):</label>
                    <input type="file" name="type_image" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white">
                </div>
            </div>
        </div>

        <!-- Частина 2: Дані екземпляра яхти (yachts) -->
        <div class="mb-6 p-4 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c]">
            <h3 class="text-lg font-bold mb-4 text-cyan-400">2. Дані екземпляра яхти (yachts)</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm">Серійний номер (serial_number):</label>
                    <input type="text" name="serial_number" placeholder="NH42-001" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white placeholder-cyan-200/50">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Рік випуску (year):</label>
                    <input type="number" name="year" min="1900" max="2100" required value="2026" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-xs">Ціна оренди ($):</label>
                    <input type="number" step="0.01" min="0" name="price_rent" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                </div>
                <div>
                    <label class="block mb-2 text-xs">Ціна покупки ($):</label>
                    <input type="number" step="0.01" min="0" name="price_buy" required class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                </div>
                <div>
                    <label class="block mb-2 text-xs">Операція (type_oper):</label>
                    <select name="type_oper" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                        <option value="rent">rent (оренда)</option>
                        <option value="buy">buy (купівля)</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-2 text-xs">Статус (status):</label>
                    <input type="text" name="status" value="available" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block mb-2 text-sm">Останнє обслуговування (last_maintenance):</label>
                    <input type="text" name="last_maintenance" value="{{ date('Y-m-d') }}" class="custom-datepicker w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white focus:outline-none focus:border-cyan-400">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Дата реєстрації (registration_date):</label>
                    <input type="text" name="registration_date" value="{{ date('Y-m-d') }}" class="custom-datepicker w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white focus:outline-none focus:border-cyan-400">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Активність (is_active):</label>
                    <select name="is_active" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white focus:outline-none focus:border-cyan-400">
                        <option value="1">Активна (1)</option>
                        <option value="0">Неактивна (0)</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block mb-2 text-sm">Коментар (comment):</label>
                <input type="text" name="comment" value="Стандартна комплектація" class="w-full p-3 rounded-xl bg-[#1a6668] border border-[#2b8a8c] text-white">
            </div>
        </div>

        <!-- Частина 3: Додаткові фотографії (yacht_photos) -->
        <div class="mb-6 p-4 bg-[#0f3d3e] rounded-2xl border border-[#2b8a8c]">
            <h3 class="text-lg font-bold mb-4 text-cyan-400">3. Додаткові фотографії (yacht_photos)</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm">Додаткове фото 1:</label>
                    <input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Додаткове фото 2:</label>
                    <input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Додаткове фото 3:</label>
                    <input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white">
                </div>
                <div>
                    <label class="block mb-2 text-sm">Додаткове фото 4:</label>
                    <input type="file" name="photos[]" class="w-full p-2 bg-[#1a6668] border border-[#2b8a8c] rounded-xl text-white">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full py-4 bg-cyan-400 text-[#0f3d3e] font-bold rounded-full hover:bg-cyan-300 transition text-lg">Зберегти яхту та тип у базу</button>
    </form>
</div>