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
    public function index()
    {
        $yachts = Yacht::with('type')->get();
        $rents = RentYacht::with('yacht')->latest()->get();
        $buys = ProdazhaYacht::with('yacht')->latest()->get();
        $types = TypeYacht::all();

        return view('admin.index', compact('yachts', 'rents', 'buys', 'types'));
    }

    public function storeYacht(Request $request)
    {
        // 1. Зберігаємо тип яхти
        $type = TypeYacht::create([
            'name_type' => $request->name_type,
            'short_description' => $request->short_description,
            'full_description' => $request->full_description,
            'image_path' => $request->hasFile('type_image') ? $request->file('type_image')->store('images', 'public') : 'default.jpg',
            'max_passengers' => $request->max_passengers,
            'length' => $request->length,
            'width' => $request->width,
            'cabins' => $request->cabins,
            'heads' => $request->heads,
            'engine_power' => $request->engine_power,
            'engine_model' => $request->engine_model,
            'year' => $request->type_year,
            'condition' => $request->condition,
        ]);

        // 2. Формуємо назву у форматі з лапками
        $generatedName = $request->name_type . ' - "' . $request->serial_number . '"';

        // Зберігаємо саму яхту
        $yacht = Yacht::create([
            'name' => $generatedName,
            'serial_number' => $request->serial_number,
            'year' => $request->year,
            'status' => $request->status,
            'price_rent' => $request->price_rent,
            'price_buy' => $request->price_buy,
            'last_maintenance' => $request->last_maintenance,
            'type_oper' => $request->type_oper,
            'type_id' => $type->id_type,
            'registration_date' => $request->registration_date,
            'is_active' => $request->is_active,
            'comment' => $request->comment,
        ]);

        // 3. Зберігаємо додаткові фотографії (максимум до 4 штук для yacht_photos)
        if ($request->hasFile('photos')) {
            $count = 0;
            foreach ($request->file('photos') as $photo) {
                if ($count >= 4) break;
                
                $path = $photo->store('images', 'public');
                YachtPhoto::create([
                    'type_id' => $type->id_type,
                    'image_path' => $path,
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.index')->with('success', 'Яхту успішно додано до бази!');
    }

    public function updateOrderStatus(Request $request)
    {
        $type = $request->input('type');
        $id = $request->input('id');
        $status = $request->input('status');

        if ($type == 'rent') {
            $order = RentYacht::findOrFail($id);
        } else {
            $order = ProdazhaYacht::findOrFail($id);
        }

        $order->status = $status;
        $order->save();

        return back()->with('success', 'Статус замовлення оновлено!');
    }
}