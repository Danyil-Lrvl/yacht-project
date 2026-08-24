<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yacht;
use App\Models\TypeYacht;
use App\Models\YachtPhoto;
use App\Models\RentYacht;
use App\Models\ProdazhaYacht;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $adminPassword = env('ADMIN_PASSWORD', 'H11Gfi');
        if ($request->password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return redirect()->route('admin.rent');
        }
        return back()->withErrors(['password' => 'Невірний пароль!']);
    }

    public function checkPassword(Request $request)
    {
        $adminPassword = env('ADMIN_PASSWORD', 'H11Gfi');
        if ($request->password === $adminPassword) {
            session(['admin_logged_in' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        session()->flush();
        return redirect()->route('admin.rent');
    }

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

    public function types(Request $request)
    {
        $query = TypeYacht::query();
        if ($request->filled('search')) { $query->where('name_type', 'like', '%' . $request->search . '%'); }
        if ($request->filled('condition')) { $query->where('condition', $request->condition); }
        if ($request->has('last_7_days')) { $query->where('created_at', '>=', now()->subDays(7)); } 
        elseif ($request->filled('date')) { $query->whereDate('created_at', $request->date); }
        $types = $query->latest('id_type')->get();
        return view('admin.types', compact('types'));
    }

    public function storeType(Request $request)
    {
        $imageName = 'default.jpg';
        if ($request->hasFile('type_image')) {
            $file = $request->file('type_image');
            $imageName = $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName);
        }

        TypeYacht::create([
            'name_type' => $request->name_type,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'image_path' => $imageName,
            'max_passengers' => $request->max_passengers,
            'length' => $request->length,
            'width' => $request->width,
            'cabins' => $request->cabins,
            'heads' => $request->heads,
            'engine_power' => $request->engine_power,
            'engine_model' => $request->engine_model,
            'year' => $request->input('type_year') ?? $request->input('year') ?? 2026,
            'condition' => $request->condition,
        ]);
        return redirect()->route('admin.types')->with('success', 'Тип яхти успішно додано!');
    }

    public function updateType(Request $request, $id)
    {
        $type = TypeYacht::findOrFail($id);
        
        $data = [
            'name_type' => $request->name_type,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'max_passengers' => $request->max_passengers,
            'length' => $request->length,
            'width' => $request->width,
            'cabins' => $request->cabins,
            'heads' => $request->heads,
            'engine_power' => $request->engine_power,
            'engine_model' => $request->engine_model,
            'year' => $request->input('type_year') ?? $request->input('year') ?? $type->year,
            'condition' => $request->condition,
        ];

        if ($request->hasFile('type_image') || $request->hasFile('image')) {
            $file = $request->file('type_image') ?? $request->file('image');
            $imageName = $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName);
            $data['image_path'] = $imageName;
        }

        $type->update($data);
        return redirect()->route('admin.types')->with('success', 'Тип яхти успішно оновлено!');
    }

    public function yachts(Request $request)
    {
        $query = Yacht::with('type');
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('serial_number', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('type_oper')) { $query->where('type_oper', $request->type_oper); }
        if ($request->filled('status')) { $query->where('status', $request->status); }
        if ($request->filled('type_id')) { $query->where('type_id', $request->type_id); }
        if ($request->has('last_7_days')) { $query->where('created_at', '>=', now()->subDays(7)); } 
        elseif ($request->filled('date')) { $query->whereDate('created_at', $request->date); }
        
        $yachts = $query->orderBy('id', 'desc')->get();
        
        $types = TypeYacht::all();
        return view('admin.yachts', compact('yachts', 'types'));
    }

    public function storeYacht(Request $request)
    {
        Yacht::create([
            'name' => $request->name,
            'status' => $request->input('status', 'available'),
            'serial_number' => $request->serial_number,
            'year' => $request->year,
            'price_rent' => $request->price_rent,
            'price_buy' => $request->price_buy,
            'last_maintenance' => $request->input('last_maintenance') ?? now()->toDateString(),
            'type_oper' => $request->type_oper,
            'type_id' => $request->input('type_id') ?? $request->input('type_yacht_id'),
            'registration_date' => $request->input('registration_date') ?? now()->toDateString(),
            'is_active' => $request->has('is_active') ? 1 : 0,
            'comment' => $request->comment,
        ]);
        return redirect()->route('admin.yachts')->with('success', 'Екземпляр яхти успішно додано!');
    }

    public function updateYacht(Request $request, $id)
    {
        $yacht = Yacht::findOrFail($id);
        $yacht->update([
            'name' => $request->name,
            'status' => $request->input('status', $yacht->status),
            'type_id' => $request->input('type_id') ?? $request->input('type_yacht_id'),
            'serial_number' => $request->serial_number,
            'year' => $request->year,
            'price_rent' => $request->price_rent,
            'price_buy' => $request->price_buy,
            'last_maintenance' => $request->input('last_maintenance') ?? $yacht->last_maintenance ?? now()->toDateString(),
            'registration_date' => $request->input('registration_date') ?? $yacht->registration_date ?? now()->toDateString(),
            'type_oper' => $request->type_oper,
            'is_active' => $request->has('is_active') ? 1 : 0,
            'comment' => $request->comment,
        ]);
        return redirect()->route('admin.yachts')->with('success', 'Дані яхти оновлено!');
    }

    public function photos(Request $request)
    {
        $query = YachtPhoto::with('typeYacht');
        if ($request->filled('type_id')) { $query->where('type_id', $request->type_id); }
        if ($request->has('last_7_days')) { $query->where('created_at', '>=', now()->subDays(7)); } 
        elseif ($request->filled('date')) { $query->whereDate('created_at', $request->date); }
        $photos = $query->latest()->get();
        $types = TypeYacht::all();
        return view('admin.photos', compact('photos', 'types'));
    }

    public function storePhotos(Request $request)
    {
        if ($request->hasFile('photos')) {
            $count = 0;
            foreach ($request->file('photos') as $photo) {
                if ($count >= 4) break;
                $imageName = $photo->getClientOriginalName();
                $photo->move(public_path('images'), $imageName);

                YachtPhoto::create([
                    'type_id' => $request->input('type_id') ?? $request->input('type_yacht_id'), 
                    'image_path' => $imageName
                ]);
                $count++;
            }
        }
        return redirect()->route('admin.photos')->with('success', 'Фотографії успішно завантажено!');
    }

    public function updatePhoto(Request $request, $id)
    {
        $photo = YachtPhoto::findOrFail($id);
        
        $updateData = [];
        if ($request->filled('type_id') || $request->filled('type_yacht_id')) {
            $updateData['type_id'] = $request->input('type_id') ?? $request->input('type_yacht_id');
        }

        if ($request->hasFile('image') || $request->hasFile('photo')) {
            $file = $request->file('image') ?? $request->file('photo');
            $imageName = $file->getClientOriginalName();
            $file->move(public_path('images'), $imageName);
            $updateData['image_path'] = $imageName;
        }

        if (!empty($updateData)) {
            $photo->update($updateData);
        }

        return redirect()->route('admin.photos')->with('success', 'Фото успішно оновлено!');
    }

    public function destroyPhoto($id)
    {
        $photo = YachtPhoto::findOrFail($id);
        $photo->delete();
        return redirect()->route('admin.photos')->with('success', 'Фотографію видалено!');
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