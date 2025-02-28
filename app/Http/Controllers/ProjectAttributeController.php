<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectAttributeController extends Controller
{
    public function setAttributes(Request $request, Project $project)
    {
        $request->validate([
            'attributes' => 'required|array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.value' => 'required'
        ]);

        foreach ($request->attributes as $attr) {
            AttributeValue::updateOrCreate(
                ['attribute_id' => $attr['id'], 'entity_id' => $project->id],
                ['value' => $attr['value']]
            );
        }

        return response()->json(['message' => 'Attributes set successfully']);
    }

    public function getProjectAttributes(Project $project)
    {
        $attributes = $project->attributes()->with('attribute')->get();
        return response()->json($attributes);
    }

    public function filterProjects(Request $request)
    {
        $query = Project::query();

        if ($request->has('attribute_id') && $request->has('value')) {
            $query->whereHas('attributes', function ($q) use ($request) {
                $q->where('attribute_id', $request->attribute_id)
                  ->where('value', $request->value);
            });
        }

        return response()->json($query->get());
    }
}
