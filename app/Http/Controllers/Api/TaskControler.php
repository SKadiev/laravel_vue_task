<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskIndexResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskControler extends Controller
{

    public function index()
    {

        $tasks = TaskIndexResource::collection(Task::orderBy('expiration', 'DESC')->get());
        return response()->json([
            "success" => true,
            "message" => "Tasks List",
            "data" => $tasks
        ]);
    }
    public function store(Request $request)
    {

        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'title' => 'required|string',
            'description' => 'required|string',
            'tasks_status_id' => 'required|number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $task =  Task::create($requestData);

        return response()->json([
            "success" => true,
            "message" => "Task created successfully.",
            "data" => $task
        ]);
    }
}
