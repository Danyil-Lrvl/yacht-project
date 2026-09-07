<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ClientYacht;
use App\Models\RentYacht;
use App\Models\ProdazhaYacht;

class ClientAuthController extends Controller
{
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