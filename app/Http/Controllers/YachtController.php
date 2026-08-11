<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yacht;
use App\Models\TypeYacht;
use App\Models\RentYacht;
use App\Models\ProdazhaYacht;
use App\Models\ClientYacht;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class YachtController extends Controller
{
    public function home()
    {
        return view('welcome');
    }

    public function index($typeName)
    {
        // Отримуємо всі типи яхт для випадаючого списку фільтрації
        $types = TypeYacht::all();
        $selectedType = request('type_id');

        if (in_array($typeName, ['rent', 'buy'])) {
            $query = Yacht::where('type_oper', $typeName);

            // Фільтрація за конкретним типом яхти, якщо він обраний у випадаючому списку
            if (!empty($selectedType)) {
                $query->where('type_id', $selectedType);
            }

            // Якщо це розділ купівлі, ховаємо яхти, на які є активна заявка молодша за 3 дні
            if ($typeName === 'buy') {
                $threeDaysAgo = Carbon::now()->subDays(3);
                
                $activeYachtIds = ProdazhaYacht::where('status', 'заявка')
                    ->where('created_at', '>=', $threeDaysAgo)
                    ->pluck('yacht_id');

                $query->whereNotIn('id', $activeYachtIds);
            }

            $yachts = $query->get();
            
            return view('welcome', compact('yachts', 'typeName', 'types', 'selectedType'))
                ->with('type', (object)['name_type' => $typeName]);
        }

        // Якщо перегляд за конкретним типом з меню
        $type = TypeYacht::where('name_type', $typeName)->firstOrFail();
        
        $query = Yacht::where('type_id', $type->id_type);
        if (!empty($selectedType)) {
            $query->where('type_id', $selectedType);
        }
        $yachts = $query->get();
        
        return view('welcome', compact('yachts', 'type', 'types', 'selectedType'));
    }

    public function show($id, $type = 'buy') 
    {
        $yacht = Yacht::with('type.photos')->findOrFail($id);
        return view('yacht-details', compact('yacht', 'type'));
    }

    public function getBookedDates($yacht_id) 
    {
        $bookings = RentYacht::where('yacht_id', $yacht_id)
            ->where('status', '!=', 'анульовано')
            ->get();
            
        $disabledDates = [];

        foreach ($bookings as $booking) {
            if (!empty($booking->start_date) && !empty($booking->end_date)) {
                try {
                    $period = CarbonPeriod::create($booking->start_date, $booking->end_date);
                    foreach ($period as $date) {
                        $disabledDates[] = $date->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    continue;
                }
            }
        }

        return response()->json(array_values(array_unique($disabledDates)));
    }

    public function showRentForm($id)
    {
        $yacht = Yacht::findOrFail($id);
        if ($yacht->type_oper !== 'rent') {
            abort(404);
        }
        return view('rent-form', compact('yacht'));
    }

    public function storeRent(Request $request)
    {
        // 1. Валідуємо дані клієнта та дати (без ціни!)
        $request->validate([
            'yacht_id'   => 'required|exists:yachts,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'full_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
        ]);

        // 2. Знаходимо яхту на сервері
        $yacht = Yacht::findOrFail($request->yacht_id);

        // 3. Безпечно беремо ціну оренди з бази даних
        $amount = $yacht->price_rent; 

        // 4. Створюємо клієнта
        $client = ClientYacht::create($request->all());

        // 5. Зберігаємо оренду із захищеною ціною з бази
        RentYacht::create([
            'yacht_id'   => $yacht->id,
            'client_id'  => $client->id,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'amount'     => $amount, 
            'status'     => 'заявка',
        ]);

        return redirect('/')->with('success', 'Заявку на оренду успішно подано!');
    }

    public function showBuyForm($id)
    {
        $yacht = Yacht::findOrFail($id);
        if ($yacht->type_oper !== 'buy') {
            abort(404);
        }
        return view('buy-form', compact('yacht'));
    }

    public function storeBuy(Request $request)
    {
        // 1. Валідуємо тільки дані клієнта та yacht_id (ціну з форми повністю ігноруємо)
        $request->validate([
            'yacht_id'  => 'required|exists:yachts,id',
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:255',
        ]);

        // 2. Знаходимо яхту на сервері
        $yacht = Yacht::findOrFail($request->yacht_id);

        // 3. Беремо реальну ціну покупки виключно з бази даних! Тепер через DevTools неможливо купити за долар.
        $amount = $yacht->price_buy;

        // 4. Створюємо клієнта
        $client = ClientYacht::create($request->all());

        // 5. Записуємо продаж із захищеною ціною
        ProdazhaYacht::create([
            'yacht_id'  => $yacht->id,
            'client_id' => $client->id,
            'amount'    => $amount,
            'status'    => 'заявка',
        ]);

        return redirect('/')->with('success', 'Заявку на покупку успішно подано! Яхта тимчасово знята з продажу на 3 дні.');
    }
}