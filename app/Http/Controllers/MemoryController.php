<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use Illuminate\Http\Request;

class MemoryController extends Controller
{
    // Display the memory wall page
    public function index()
    {
        return view('memories.index');
    }

    // Get all memories (API)
    public function getMemories()
    {
        $memories = Memory::orderBy('created_at', 'desc')->get();
        
        return response()->json([
            'success' => true,
            'memories' => $memories->map(function($memory) {
                return [
                    'id' => $memory->id,
                    'text' => $memory->memory_text,
                    'date' => $memory->created_at->format('n/j/Y'),
                    'time' => $memory->created_at->format('g:i A')
                ];
            })
        ]);
    }

    // Create new memory (API)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'memory' => 'required|string|max:1000'
        ]);

        $memory = Memory::create([
            'memory_text' => $validated['memory']
        ]);

        return response()->json([
            'success' => true,
            'memory' => [
                'id' => $memory->id,
                'text' => $memory->memory_text,
                'date' => $memory->created_at->format('n/j/Y'),
                'time' => $memory->created_at->format('g:i A')
            ]
        ]);
    }

    // Update existing memory (API)
    public function update(Request $request, $id)
    {
        $memory = Memory::find($id);

        if (!$memory) {
            return response()->json([
                'success' => false,
                'error' => 'Memory not found'
            ], 404);
        }

        $validated = $request->validate([
            'memory' => 'required|string|max:1000'
        ]);

        $memory->update([
            'memory_text' => $validated['memory']
        ]);

        return response()->json([
            'success' => true,
            'memory' => [
                'id' => $memory->id,
                'text' => $memory->memory_text,
                'date' => $memory->created_at->format('n/j/Y'),
                'time' => $memory->created_at->format('g:i A')
            ]
        ]);
    }

    // Delete memory (API)
    public function destroy($id)
    {
        $memory = Memory::find($id);

        if (!$memory) {
            return response()->json([
                'success' => false,
                'error' => 'Memory not found'
            ], 404);
        }

        $memory->delete();

        return response()->json([
            'success' => true,
            'message' => 'Memory deleted successfully'
        ]);
    }
}