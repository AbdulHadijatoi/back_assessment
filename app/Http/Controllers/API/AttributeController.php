<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttributeController extends Controller
{
    public function index()
    {
        return response()->json(Attribute::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:attributes,name',
            'type' => 'required|in:text,date,number,select',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $attribute = Attribute::create($request->all());

        return response()->json($attribute, 201);
    }

    public function show($id)
    {
        $attribute = Attribute::find($id);
        return $attribute ? response()->json($attribute, 200) : response()->json(['error' => 'Attribute Not Found'], 404);
    }

    public function update(Request $request, $id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json(['error' => 'Attribute Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|unique:attributes,name,' . $id,
            'type' => 'sometimes|in:text,date,number,select',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $attribute->update($request->only(['name', 'type']));

        return response()->json($attribute, 200);
    }

    public function destroy($id)
    {
        $attribute = Attribute::find($id);
        if (!$attribute) {
            return response()->json(['error' => 'Attribute Not Found'], 404);
        }
        $attribute->delete();
        return response()->json(['message' => 'Attribute Deleted'], 200);
    }
}
