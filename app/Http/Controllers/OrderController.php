<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Yacht;
use App\Models\RentYacht;
use App\Models\ProdazhaYacht;
use App\Models\ClientYacht;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function getBookedDates($yacht_id) 
    {
        $bookings = RentYacht::where('yacht_id', $yacht_id)
            ->whereNotIn('status', ['cancelled', 'анульовано'])
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
        $validatedData = $request->validate([
            'yacht_id'              => 'required|exists:yachts,id',
            'start_date'            => 'required|date|after_or_equal:today',
            'end_date'              => 'required|date|after_or_equal:start_date',
            'full_name'             => 'required|string|max:255',
            'phone'                 => 'required|string|max:255',
            'email'                 => 'required|email|max:255',
            'initial_price_per_day' => 'required|numeric|min:0',
            'document_number'       => 'nullable|string|max:255',
            'document_date'         => 'nullable|date',
            'document_issued_by'    => 'nullable|string|max:255',
            'address'               => 'nullable|string|max:255',
            'tax_id'                => 'nullable|string|max:255',
        ]);

        $yacht = Yacht::findOrFail($validatedData['yacht_id']);

        // Перевірка актуальності ціни
        if ((float) $yacht->price_rent !== (float) $validatedData['initial_price_per_day']) {
            throw ValidationException::withMessages([
                'start_date' => 'Увага! Ціна на оренду цієї яхти оновилася адміністратором. Будь ласка, перегляньте нові умови.',
            ]);
        }

        // Перевірка на перетин дат
        $isBooked = RentYacht::where('yacht_id', $yacht->id)
            ->whereNotIn('status', ['cancelled', 'анульовано'])
            ->where(function ($query) use ($validatedData) {
                $query->whereBetween('start_date', [$validatedData['start_date'], $validatedData['end_date']])
                      ->orWhereBetween('end_date', [$validatedData['start_date'], $validatedData['end_date']])
                      ->orWhere(function ($q) use ($validatedData) {
                          $q->where('start_date', '<=', $validatedData['start_date'])
                            ->where('end_date', '>=', $validatedData['end_date']);
                      });
            })
            ->exists();

        if ($isBooked) {
            throw ValidationException::withMessages([
                'start_date' => 'Обрані дати вже зайняті для оренди цієї яхти.',
            ]);
        }

        // Розрахунок суми
        $startDate = Carbon::parse($validatedData['start_date']);
        $endDate = Carbon::parse($validatedData['end_date']);
        $daysCount = $startDate->diffInDays($endDate) + 1;
        
        $pricePerDay = $yacht->price_rent ?? 0;
        $calculatedAmount = $daysCount * $pricePerDay;

        // РОБОТА З КЛІЄНТОМ (Оновлюємо або створюємо через валідовані дані)
        if (Auth::guard('client')->check()) {
            $client = Auth::guard('client')->user();
            $client->update($validatedData);
            $clientId = $client->id;
        } else {
            $client = ClientYacht::where('email', $validatedData['email'])->first();

            if ($client) {
                $client->update($validatedData);
            } else {
                $clientData = $validatedData;
                $clientData['password'] = Hash::make(Str::random(16));
                
                $client = ClientYacht::create($clientData);
            }
            $clientId = $client->id;
        }

        RentYacht::create([
            'yacht_id'       => $yacht->id,
            'client_id'      => $clientId,
            'start_date'     => $validatedData['start_date'],
            'end_date'       => $validatedData['end_date'],
            'operation_date' => now(),
            'amount'         => $calculatedAmount,
            'status'         => 'заявка',
        ]);

        return redirect('/')->with('success', "Заявку на оренду успішно подано! Сума до сплати: {$calculatedAmount} $.");
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
        $validatedData = $request->validate([
            'yacht_id'  => 'required|exists:yachts,id',
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:255',
            'email'     => 'required|email|max:255',
        ]);

        $yacht = Yacht::findOrFail($validatedData['yacht_id']);
        $amount = $yacht->price_buy;
        
        if (Auth::guard('client')->check()) {
            $client = Auth::guard('client')->user();
            $client->update($validatedData);
            $clientId = $client->id;
        } else {
            $client = ClientYacht::where('email', $validatedData['email'])->first();

            if ($client) {
                $client->update($validatedData);
            } else {
                $clientData = $validatedData;
                $clientData['password'] = Hash::make(Str::random(16));
                
                $client = ClientYacht::create($clientData);
            }
            $clientId = $client->id;
        }

        ProdazhaYacht::create([
            'yacht_id'  => $yacht->id,
            'client_id' => $clientId,
            'sale_date' => now(),
            'amount'    => $amount,
            'status'    => 'заявка',
        ]);

        return redirect('/')->with('success', 'Заявку на покупку успішно подано!');
    }
}