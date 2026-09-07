<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RentYacht;
use App\Models\ProdazhaYacht;

class AdminRentBuyController extends Controller
{
    public function rent(Request $request)
    {
        $query = RentYacht::with(['yacht', 'client']);
        if ($request->filled('status')) { $query->where('status', $request->status); }
        if ($request->has('last_7_days')) { $query->where('created_at', '>=', now()->subDays(7)); } 
        elseif ($request->filled('date')) { $query->whereDate('created_at', $request->date); }
        $rents = $query->latest()->get();
        return view('admin.rent', compact('rents'));
    }

    public function buy(Request $request)
    {
        $query = ProdazhaYacht::with(['yacht', 'client']);
        if ($request->filled('status')) { $query->where('status', $request->status); }
        if ($request->has('last_7_days')) { $query->where('created_at', '>=', now()->subDays(7)); } 
        elseif ($request->filled('date')) { $query->whereDate('created_at', $request->date); }
        $buys = $query->latest()->get();
        return view('admin.buy', compact('buys'));
    }

    public function updateOrderStatus(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $status = $request->input('status');
        $order = ($type == 'rent') ? RentYacht::findOrFail($id) : ProdazhaYacht::findOrFail($id);
        $order->status = $status;
        $order->save();
        return back()->with('success', 'Статус замовлення оновлено!');
    }
}