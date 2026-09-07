<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TypeYacht;

class AdminTypeController extends Controller
{
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
}