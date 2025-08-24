<?php
namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TodoController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Todo::class);

        $user = auth()->user();

        $todos = $user->is_admin
            ? Todo::all()
            : $user->todos;

        return response()->json($todos);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Todo::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $todo = auth()->user()->todos()->create($validated);

        return response()->json($todo, 201);
    }

    public function show(Todo $todo)
    {
        $this->authorize('view', $todo);

        return response()->json($todo);
    }

    public function update(Request $request, Todo $todo)
    {
        $this->authorize('update', $todo);

        $validated = $request->validate([
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $todo->update($validated);

        return response()->json($todo);
    }

    public function destroy(Todo $todo)
    {
        $this->authorize('delete', $todo);
    
        $id = $todo->id;

        $todo->delete();

        return response()->json([
            'message' => "A(z) {$id} azonosítójú rekord törölve.",            
        ], 
        202);
    }
}
