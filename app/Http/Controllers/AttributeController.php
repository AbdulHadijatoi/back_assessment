<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        return response()->json(Attribute::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:attributes,name',
            'type' => 'required|in:text,date,number,select',
        ]);

        $attribute = Attribute::create($request->all());
        return response()->json($attribute, 201);
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'sometimes|string|unique:attributes,name,' . $attribute->id,
            'type' => 'sometimes|in:text,date,number,select',
        ]);

        $attribute->update($request->all());
        return response()->json($attribute);
    }
}
