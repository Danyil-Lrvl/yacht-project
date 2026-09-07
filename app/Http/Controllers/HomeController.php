<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yacht;
use App\Models\TypeYacht;

class HomeController extends Controller
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
}