<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
use App\Models\Tasks;

class TaskController extends Controller
{

    /**
     * Retrieve all tasks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tasks = Tasks::all();
        return response()->json(['tasks' => $tasks]);
    }

    /**
     * Store a newly created task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'task' => 'required|string',
            'start_time' => 'nullable|date_format:H:i:s',
            'end_time' => 'nullable|date_format:H:i:s',
            'date' => 'required',
        ]);

        $task = Tasks::create($request->all());
        return response()->json(['task' => $task], 201);
    }

    /**
     * Display the specified task.
     *
     * @param  \App\Models\Tasks  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tasks $task)
    {
        return response()->json(['task' => $task]);
    }

    /**
     * Update the specified task.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tasks  $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Tasks $task)
    {
        $this->validate($request, [
            'task' => 'required|string',
            'start_time' => 'nullable|date_format:H:i:s',
            'end_time' => 'nullable|date_format:H:i:s',
            'date' => 'required|date',
        ]);

        $task->update($request->all());
        return response()->json(['task' => $task]);
    }

    /**
     * Remove the specified task from storage.
     *
     * @param  \App\Models\Tasks  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $task)
    {
        $task->delete();
        return response()->json(null, 204);
    }
}
