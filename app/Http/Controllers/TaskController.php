<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Display the task list for the logged-in user
    public function index()
    {
        $tasks = Auth::user()->tasks;  // Fetch only the tasks of the logged-in user
        return view('tasks.index', compact('tasks'));
    }

    // Add a new task for the logged-in user
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Auth::user()->tasks()->create(['name' => $request->name]);
        return redirect()->route('tasks.index');
    }

    // Toggle task completion status
    public function toggleComplete(Task $task)
    {
        // Ensure the task belongs to the logged-in user
        if ($task->user_id === Auth::id()) {
            $task->completed = !$task->completed;
            $task->save();
        }
        return redirect()->route('tasks.index');
    }

    // Delete a task
    public function destroy(Task $task)
    {
        // Ensure the task belongs to the logged-in user
        if ($task->user_id === Auth::id()) {
            $task->delete();
        }
        return redirect()->route('tasks.index');
    }
}
