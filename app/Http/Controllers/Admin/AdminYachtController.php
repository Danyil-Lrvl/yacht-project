<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Yacht;
use App\Models\TypeYacht;

class AdminYachtController extends Controller
{
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
        // Уніфікація назви поля типу яхти перед валідацією
        if (!$request->filled('type_id') && $request->filled('type_yacht_id')) {
            $request->merge(['type_id' => $request->type_yacht_id]);
        }

        // Повна валідація (змінено 'photo' на 'image' відповідно до форми)
        $validatedData = $request->validate([
            'name'              => 'required|string|max:255',
            'status'            => 'nullable|string|max:50',
            'serial_number'     => 'nullable|string|max:255',
            'year'              => 'nullable|integer|min:1900|max:2100',
            'price_rent'        => 'nullable|numeric|min:0',
            'price_buy'         => 'nullable|numeric|min:0',
            'last_maintenance'  => 'nullable|date',
            'type_oper'         => 'required|string|max:50',
            'type_id'           => 'nullable|exists:type_yachts,id',
            'registration_date' => 'nullable|date',
            'comment'           => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Значення за замовчуванням
        $validatedData['status'] = $validatedData['status'] ?? 'available';
        $validatedData['last_maintenance'] = $validatedData['last_maintenance'] ?? now()->toDateString();
        $validatedData['registration_date'] = $validatedData['registration_date'] ?? now()->toDateString();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        // Збереження файлу в пачку public/images/
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            
            // Якщо у вашій базі колонка називається 'image', а не 'photo':
            $validatedData['image'] = $filename;
        }

        Yacht::create($validatedData);

        return redirect()->route('admin.yachts')->with('success', 'Екземпляр яхти успішно додано!');
    }

    public function updateYacht(Request $request, $id)
    {
        $yacht = Yacht::findOrFail($id);

        if (!$request->filled('type_id') && $request->filled('type_yacht_id')) {
            $request->merge(['type_id' => $request->type_yacht_id]);
        }

        $validatedData = $request->validate([
            'name'              => 'required|string|max:255',
            'status'            => 'nullable|string|max:50',
            'serial_number'     => 'nullable|string|max:255',
            'year'              => 'nullable|integer|min:1900|max:2100',
            'price_rent'        => 'nullable|numeric|min:0',
            'price_buy'         => 'nullable|numeric|min:0',
            'last_maintenance'  => 'nullable|date',
            'type_oper'         => 'required|string|max:50',
            'type_id'           => 'nullable|exists:type_yachts,id',
            'registration_date' => 'nullable|date',
            'comment'           => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $validatedData['status'] = $validatedData['status'] ?? $yacht->status;
        $validatedData['last_maintenance'] = $validatedData['last_maintenance'] ?? $yacht->last_maintenance ?? now()->toDateString();
        $validatedData['registration_date'] = $validatedData['registration_date'] ?? $yacht->registration_date ?? now()->toDateString();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        // Якщо завантажено нове фото — видаляємо старе з public/images/ та зберігаємо нове
        if ($request->hasFile('image')) {
            if (!empty($yacht->image)) {
                $oldPath = public_path('images/' . $yacht->image);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            
            $validatedData['image'] = $filename;
        }

        // Оновлюємо дані
        $yacht->update($validatedData);

        return redirect()->route('admin.yachts')->with('success', 'Дані яхти оновлено!');
    }
}