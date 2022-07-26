<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskIndexResource;
use App\Models\Task;
use App\Models\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskControler extends Controller
{

    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $tasks = TaskIndexResource::collection(Task::orderBy('expiration', 'DESC')->get());
        } else {
            $tasks = TaskIndexResource::collection(Task::orderBy('expiration', 'DESC')->where('user_id', auth()->user()->id)->get());
        }

        return response()->json([
            "success" => true,
            "message" => "Tasks List",
            "data" => $tasks
        ]);
    }


    public function show(Task $task)
    {
        return response()->json([
            "success" => true,
            "message" => "Task found",
            "data" => $task
        ]);
    }

    public function update(Request $request)
    {

        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'id' => 'required',
            'title' => 'required|string',
            'description' => 'required|string',
            'expiration' => 'required',
            'tasks_status_id' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $requestData['expiration'] =  Carbon::parse($requestData['expiration'])->toDateTimeString();

        $task =  Task::findOrFail($requestData['id']);
        $task->update($requestData);
        return response()->json([
            "success" => true,
            "message" => "Task update successfully.",
            "data" => $task
        ]);
    }

    public function store(Request $request)
    {

        $requestData = $request->all();
        $validator = Validator::make($requestData, [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        $requestData['expiration'] =  Carbon::parse($requestData['expiration'])->toDateTimeString();

        $task =  Task::make($requestData);
        $task->user_id = Auth::user()->id;
        $task->save();
        return response()->json([
            "success" => true,
            "message" => "Task created successfully.",
            "data" => $task
        ]);
    }


    public function sortByExpiration(String $expiration)
    {


        if (empty($expiration)) {
            return response()->json([
                'errors' => 'Expiration field empty'
            ], 422);
        }
        $tasks = Task::where('expiration', '<=',  $expiration)->get();


        if (auth()->user()->isAdmin()) {
            $tasks = Task::where('expiration', '<=',  $expiration)->get();
        } else {
            $tasks =
                Task::orderBy('expiration', 'DESC')->where('user_id', auth()->user()->id)->where('expiration', '>=',  $expiration)->get();
        }

        return response()->json([
            "success" => true,
            "message" => "Tasks List",
            "data" => $tasks
        ]);
    }

    public function taskStatusList()
    {
        $tasksStatusList = TaskStatus::all();

        return response()->json([
            "success" => true,
            "message" => "Tasks status List",
            "data" => $tasksStatusList
        ]);
    }

    public function searchByName(Request $request)
    {
        if ($request->has('username')) {
            $username = $request->input('username');
            $taskByName = Task::whereHas('user', function ($q) use ($username) {
                $q->where('name', $username);
            })->get();

            return response()->json([
                "success" => true,
                "message" => "Task list",
                "data" => $taskByName
            ]);
        } else {

            return response()->json([
                "success" => false,
                "message" => "Wrong request",
            ]);
        }
    }
}
