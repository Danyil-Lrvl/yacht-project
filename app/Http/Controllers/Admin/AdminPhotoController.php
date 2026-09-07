<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\YachtPhoto;
use App\Models\TypeYacht;

class AdminPhotoController extends Controller
{
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
        // Нормалізація вхідного поля типу
        if (!$request->filled('type_id') && $request->filled('type_yacht_id')) {
            $request->merge(['type_id' => $request->type_yacht_id]);
        }

        // Строга валідація для завантаження фотографій (максимум 4 файли за раз)
        $request->validate([
            'type_id'   => 'required|exists:type_yachts,id',
            'photos'    => 'required|array|max:4',
            'photos.*'  => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                // Генеруємо унікальну назву та переносимо в public/images/
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $filename);

                YachtPhoto::create([
                    'type_id'    => $request->type_id, 
                    'image_path' => $filename
                ]);
            }
        }

        return redirect()->route('admin.photos')->with('success', 'Фотографії успішно завантажено!');
    }

    public function updatePhoto(Request $request, $id)
    {
        $photo = YachtPhoto::findOrFail($id);

        if (!$request->filled('type_id') && $request->filled('type_yacht_id')) {
            $request->merge(['type_id' => $request->type_yacht_id]);
        }

        $request->validate([
            'type_id' => 'sometimes|exists:type_yachts,id',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);
        
        $updateData = [];
        if ($request->filled('type_id')) {
            $updateData['type_id'] = $request->type_id;
        }

        $file = $request->file('image') ?? $request->file('photo');
        if ($file) {
            // Видаляємо старе фото з public/images/ якщо воно існує
            if (!empty($photo->image_path)) {
                $oldPath = public_path('images/' . $photo->image_path);
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            // Зберігаємо нове фото в public/images/
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);

            $updateData['image_path'] = $filename;
        }

        if (!empty($updateData)) {
            $photo->update($updateData);
        }

        return redirect()->route('admin.photos')->with('success', 'Фото успішно оновлено!');
    }

    public function destroyPhoto($id)
    {
        $photo = YachtPhoto::findOrFail($id);

        // Видаляємо файл з public/images/ перед видаленням запису з бази
        if (!empty($photo->image_path)) {
            $filePath = public_path('images/' . $photo->image_path);
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        $photo->delete();
        
        return redirect()->route('admin.photos')->with('success', 'Фотографію видалено!');
    }
}