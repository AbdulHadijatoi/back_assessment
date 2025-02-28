<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    public function index()
    {
        return response()->json(Timesheet::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'user_id'    => 'required|exists:users,id',
            'date'       => 'required|date',
            'hours'      => 'required|integer|min:1|max:24',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $timesheet = Timesheet::create($request->all());

        return response()->json($timesheet, 201);
    }

    public function show($id)
    {
        $timesheet = Timesheet::find($id);
        return $timesheet ? response()->json($timesheet, 200) : response()->json(['error' => 'Timesheet Not Found'], 404);
    }

    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet) {
            return response()->json(['error' => 'Timesheet Not Found'], 404);
        }

        $timesheet->update($request->only(['project_id', 'user_id', 'date', 'hours']));

        return response()->json($timesheet, 200);
    }

    public function destroy($id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet) {
            return response()->json(['error' => 'Timesheet Not Found'], 404);
        }
        $timesheet->delete();
        return response()->json(['message' => 'Timesheet Deleted'], 200);
    }
}
