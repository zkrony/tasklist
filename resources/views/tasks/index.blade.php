<!-- resources/views/tasks/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager for Rentex Group</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .completed {
            text-decoration: line-through;
            color: gray;
        }
    </style>
</head>

<body class="bg-gradient-to-r from-blue-100 to-blue-200 min-h-screen p-6">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
        <header class="bg-blue-600 text-white text-center py-4">
            <h1 class="text-3xl font-bold">Task Manager for Rentex Group</h1>
        </header>

        <div class="p-6">
            <!-- Display authentication links -->
            @auth
            <div class="flex justify-between items-center mb-4">
                <p class="text-lg">Hello, <span class="font-semibold">{{ Auth::user()->name }}</span>!</p>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="text-red-500 hover:text-red-700 transition">Logout <i class="fas fa-sign-out-alt"></i></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

            <!-- Add Task Form -->
            <form action="{{ route('tasks.store') }}" method="POST" class="flex mb-6">
                @csrf
                <input type="text" name="name" placeholder="Enter a new task"
                    class="flex-1 border-2 border-blue-300 rounded-l p-2 focus:outline-none focus:border-blue-500"
                    required>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white p-2 rounded-r transition-colors">
                    <i class="fas fa-plus"></i> Add
                </button>
            </form>

            <!-- Display Task List -->
            <ul class="space-y-2">
                @forelse ($tasks as $task)
                <li
                    class="flex justify-between items-center p-4 bg-gray-100 rounded-lg hover:bg-gray-200 transition group">
                    <span class="{{ $task->completed ? 'completed' : '' }}">{{ $task->name }}</span>
                    <div class="flex space-x-2">
                        <!-- Toggle Completion -->
                        <form action="{{ route('tasks.toggleComplete', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="text-sm bg-green-400 hover:bg-green-500 text-white p-1 rounded transition"
                                title="{{ $task->completed ? 'Mark as Incomplete' : 'Mark as Complete' }}">
                                <i
                                    class="{{ $task->completed ? 'fas fa-undo' : 'fas fa-check' }}"></i>
                            </button>
                        </form>
                        <!-- Delete Task -->
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-sm bg-red-400 hover:bg-red-500 text-white p-1 rounded transition"
                                title="Delete Task">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </li>
                @empty
                <li class="text-gray-500 text-center">No tasks available. Add your first task!</li>
                @endforelse
            </ul>
            @else
            <div class="text-center">
                <p class="mb-4">Please <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Login</a> or <a href="{{ route('register') }}"
                        class="text-blue-500 hover:underline">Register</a> to manage your tasks.</p>
            </div>
            @endauth
        </div>
    </div>
</body>

</html>
