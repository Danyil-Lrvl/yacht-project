<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $types = TypeYacht::all();
        $selectedType = request('type_id');
        $typeName = strtolower(trim($typeName));

        if (in_array($typeName, ['rent', 'buy'])) {
            $query = Yacht::where('type_oper', $typeName);
            if (!empty($selectedType)) {
                $query->where('type_id', $selectedType);
            }
            $yachts = $query->get();
            
            return view('welcome', compact('yachts', 'typeName', 'types', 'selectedType'))
                ->with('type', (object)['name_type' => $typeName]);
        }

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
        $request->validate([
            'yacht_id'   => 'required|exists:yachts,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'full_name'  => 'required|string|max:255',
            'phone'      => 'required|string|max:255',
            'amount'     => 'required|numeric|min:0',
        ]);

        $yacht = Yacht::findOrFail($request->yacht_id);
        
        $clientId = Auth::guard('client')->check() ? Auth::guard('client')->id() : null;

        if (!$clientId) {
            $client = ClientYacht::create([
                'full_name' => $request->full_name,
                'phone'     => $request->phone,
                'email'     => $request->email ?? 'no-email@client.com',
                'password'  => Hash::make('default_password')
            ]);
            $clientId = $client->id;
        }

        RentYacht::create([
            'yacht_id'       => $yacht->id,
            'client_id'      => $clientId,
            'start_date'     => $request->start_date,
            'end_date'       => $request->end_date,
            'operation_date' => now(),
            'amount'         => $request->amount,
            'status'         => 'заявка',
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
        $request->validate([
            'yacht_id'  => 'required|exists:yachts,id',
            'full_name' => 'required|string|max:255',
            'phone'     => 'required|string|max:255',
        ]);

        $yacht = Yacht::findOrFail($request->yacht_id);
        $amount = $yacht->price_buy;

        $clientId = Auth::guard('client')->check() ? Auth::guard('client')->id() : null;

        if (!$clientId) {
            $client = ClientYacht::create([
                'full_name' => $request->full_name,
                'phone'     => $request->phone,
                'email'     => $request->email ?? 'no-email@client.com',
                'password'  => Hash::make('default_password')
            ]);
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

    // --- АВТОРИЗАЦІЯ ТА ПРОФІЛЬ ---
    public function showLoginForm() { return view('account.login'); }
    public function showRegisterForm() { return view('account.register'); }

    public function registerClient(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:clients_yachts,email',
            'password' => 'required|min:6',
        ]);

        $client = ClientYacht::create([
            'full_name' => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        Auth::guard('client')->login($client);
        return redirect('/')->with('success', 'Акаунт успішно створено!');
    }

    public function loginClient(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('client')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Успішний вхід!');
        }

        return back()->withErrors(['email' => 'Невірні дані для входу.']);
    }

    public function logoutClient(Request $request)
    {
        Auth::guard('client')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showClientData()
    {
        $client = Auth::guard('client')->user();
        return view('account.my-data', compact('client'));
    }

    public function updateClientData(Request $request)
    {
        $client = Auth::guard('client')->user();
        $request->validate([
            'full_name'          => 'required|string|max:255',
            'document_number'    => 'nullable|string|max:50',
            'document_issued_by' => 'nullable|string|max:255',
            'document_date'      => 'nullable|date',
            'phone'              => 'nullable|string|max:20',
            'address'            => 'nullable|string',
            'tax_id'             => 'nullable|string|max:50',
        ]);

        $client->update($request->all());
        return redirect()->route('client.data')->with('success', 'Дані успішно оновлено!');
    }

    public function showClientActions()
    {
        $client = Auth::guard('client')->user();
        $rents = RentYacht::where('client_id', $client->id)->with('yacht')->get();
        $sales = ProdazhaYacht::where('client_id', $client->id)->with('yacht')->get();
        return view('account.my-actions', compact('client', 'rents', 'sales'));
    }
}