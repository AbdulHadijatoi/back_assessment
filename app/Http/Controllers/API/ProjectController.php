<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json(Project::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string|max:255',
            // 'status' => 'required|string',
            'attributes' => 'array'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $project = Project::create([
            'name'   => $request->name,
            // 'status' => $request->status,
        ]);

        // Save dynamic attributes
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attrName => $value) {
                $attribute = Attribute::firstOrCreate(['name' => $attrName]);
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'entity_id'    => $project->id,
                    'value'        => $value,
                ]);
            }
        }

        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::with('attributeValues.attribute')->find($id);
        return $project ? response()->json($project, 200) : response()->json(['error' => 'Not Found'], 404);
    }

    public function update(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Not Found'], 404);
        }

        $project->update($request->only(['name', 'status']));

        // Update attributes
        if ($request->has('attributes')) {
            foreach ($request->attributes as $attrName => $value) {
                $attribute = Attribute::firstOrCreate(['name' => $attrName]);
                AttributeValue::updateOrCreate(
                    ['attribute_id' => $attribute->id, 'entity_id' => $project->id],
                    ['value' => $value]
                );
            }
        }

        return response()->json($project, 200);
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['error' => 'Not Found'], 404);
        }
        $project->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }

    public function filter(Request $request)
    {
        $query = Project::query();

        foreach ($request->filters ?? [] as $key => $value) {
            if (in_array($key, ['name', 'status'])) {
                $query->where($key, 'LIKE', "%$value%");
            } else {
                $query->whereHas('attributeValues', function ($q) use ($key, $value) {
                    $q->whereHas('attribute', function ($q) use ($key) {
                        $q->where('name', $key);
                    })->where('value', 'LIKE', "%$value%");
                });
            }
        }

        return response()->json($query->get(), 200);
    }
}
