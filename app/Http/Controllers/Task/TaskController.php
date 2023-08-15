<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use Intervention\Image\Facades\Image;
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
        // Fetch all tasks from the database
        $tasks = Tasks::all();

        // Return the tasks in a JSON response
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
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [

            // Define validation rules for the fields
            'task' => 'required|string',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
            'color' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $save_url = null; // Initialize the image URL variable

            // Process and save the image if provided
            if ($request->hasFile('image')) {

                // Handle image upload and resizing
                $image = $request->file('image');
                $filename = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
                $path = public_path('upload/task/');
                Image::make($image)->resize(900, 900)->save($path . $filename);

                // Set the image URL for saving in the database
                $save_url = url('upload/task/') . '/' . $filename;
            }

            // Create a new task record in the database
            Tasks::create([
                'task' => $request->task,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'color' => $request->color,
                'image' => $save_url,
            ]);

            DB::commit();

            // Return a success response
            return response()->json(['status' => true, 'message' => 'Task inserted successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();

            // Handle errors during task creation
            return response()->json(['message' => 'An error occurred while creating the task', 'error' => $e->getMessage()], 500);
        }
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
        // Validate incoming request data
        $validatedData = $request->validate([
            'task' => 'required|string',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
            'color' => 'nullable',
            // 'image' => 'nullable',
        ]);

        // Update task attributes (excluding image)
        $task->fill($validatedData);

        if ($request->hasFile('image')) {
            // Handle image update if provided

            $image = $request->file('image');
            $filename = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            $path = 'upload/task/';
            $imagePath = $path . $filename;

            // Move the uploaded image to the desired location
            $image->move($path, $filename);

            // Delete the previous image if it exists
            if ($task->image && file_exists(public_path($task->image))) {
                unlink(public_path($task->image));
            }

            $task->image = $imagePath;
        }

        // Save the updated task
        $task->save();

        // Return a response with the updated task
        return response()->json(['task' => $task]);
    }

    public function updateTask(Request $request, $id)
    {
        try {
            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'task' => 'required|string',
                'start_time' => 'nullable|date',
                'end_time' => 'nullable|date',
                'color' => 'nullable',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Handle validation errors
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Find the task by ID
            $task = Tasks::findOrFail($id);

            // Begin a database transaction
            DB::beginTransaction();

            // Process and save the image if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
                $path = public_path('upload/task/');
                Image::make($image)->resize(900, 900)->save($path . $filename);

                // Set the image URL for saving in the database
                $task->image = url('upload/task/') . '/' . $filename;
            }

            // Update task properties
            $task->task = $request->task;
            $task->start_time = $request->start_time;
            $task->end_time = $request->end_time;
            $task->color = $request->color;
            $task->save();

            // Commit the transaction
            DB::commit();

            // Return a success response
            return response()->json(['status' => true, 'message' => 'Task updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle errors and rollback the transaction
            DB::rollback();

            return response()->json(['message' => 'An error occurred while updating the task', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified task.
     *
     * @param  \App\Models\Tasks  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Tasks $task)
    {
        // Return the specified task in a JSON response
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
        // Delete the specified task from the database
        $task->delete();

        // Return a response indicating successful deletion (status code 204)
        return response()->json(null, 204);
    }
}
