<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'message' => 'Berhasil semua tasks',
            'data' => TaskResource::collection($tasks),
        ],200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $task = Task::create($validated);

        return response()->json($task,201);
    }

    public function show($id){
        $task = Task::find($id);

        if(!$task){
            return response()->json([
                'message' => 'Task tidak ditemukan'

            ],404);
        }
        return response()->json($task);
    }

    public function update(Request $request, $id){
        $task = Task::find($id);

        if(!$task){
            return response()->json([
                'message' => 'Task tidak ditemukan'

            ],404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => '|boolean',
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if(!$task){
            return response()->json([
                'message' => 'Task tidak ditemukan',
            ],404);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task berhasil dihapus'
        ]);
    }
}
