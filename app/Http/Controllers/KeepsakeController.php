<?php

namespace App\Http\Controllers;

use App\Models\Keepsake;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Keepsake Controller
 * Handles all keepsake CRUD operations, filtering, and special features
 */
class KeepsakeController extends Controller
{
    /**
     * Display the keepsakes page
     */
    public function index(Request $request)
    {
        $query = Keepsake::query();
        
        // Apply filters
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        if ($request->filled('mood')) {
            $query->byMood($request->mood);
        }
        
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        if ($request->filled('favorites')) {
            $query->favorites();
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->dateRange($request->start_date, $request->end_date);
        }
        
        // Get keepsakes
        $keepsakes = $query->orderByDate()->get();
        
        // Get monthly stats for calendar
        $monthlyStats = Keepsake::getMonthlyStats();
        
        // Get categories
        $categories = Keepsake::getCategories();
        
        return view('keepsakes.index', compact('keepsakes', 'monthlyStats', 'categories'));
    }

    /**
     * Get keepsakes as JSON (for AJAX requests)
     */
    public function getKeepsakes(Request $request)
    {
        $query = Keepsake::query();
        
        // Apply filters
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        if ($request->filled('mood')) {
            $query->byMood($request->mood);
        }
        
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        if ($request->filled('favorites')) {
            $query->favorites();
        }
        
        if ($request->filled('view')) {
            // Different sorting for different views
            switch ($request->view) {
                case 'timeline':
                    $query->orderByDate('desc');
                    break;
                case 'calendar':
                    $query->orderByDate('desc');
                    break;
                default:
                    $query->orderByDate('desc');
            }
        }
        
        $keepsakes = $query->get()->map(function($keepsake) {
            return [
                'id' => $keepsake->id,
                'title' => $keepsake->title,
                'description' => $keepsake->description,
                'memory_date' => $keepsake->memory_date->format('Y-m-d'),
                'formatted_date' => $keepsake->formatted_date,
                'category' => $keepsake->category,
                'category_details' => $keepsake->category_details,
                'mood' => $keepsake->mood,
                'tags' => $keepsake->tags,
                'image_url' => $keepsake->image_url,
                'is_favorite' => $keepsake->is_favorite,
                'is_private' => $keepsake->is_private,
                'created_by' => $keepsake->created_by,
            ];
        });
        
        return response()->json($keepsakes);
    }

    /**
     * Store a new keepsake
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'memory_date' => 'required|date',
            'category' => 'required|string',
            'mood' => 'nullable|string|max:20',
            'tags' => 'nullable|array',
            'image' => 'nullable|string', // Base64 image
            'is_favorite' => 'boolean',
            'is_private' => 'boolean',
            'password' => 'nullable|string|min:4',
            'created_by' => 'nullable|string|max:100',
        ]);
        
        // Handle image upload if provided
        if ($request->filled('image')) {
            $imageData = $request->image;
            
            // Check if it's base64
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]); // jpg, png, gif
                
                if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
                    return response()->json(['error' => 'Invalid image type'], 400);
                }
                
                $imageData = base64_decode($imageData);
                
                if ($imageData === false) {
                    return response()->json(['error' => 'Base64 decode failed'], 400);
                }
                
                // Generate unique filename
                $filename = 'keepsake_' . Str::uuid() . '.' . $type;
                
                // Store in public disk
                Storage::disk('public')->put('keepsakes/' . $filename, $imageData);
                
                $validated['image_path'] = 'keepsakes/' . $filename;
                $validated['image_type'] = $type;
            }
        }
        
        // Create keepsake
        $keepsake = Keepsake::create($validated);
        
        return response()->json([
            'success' => true,
            'keepsake' => $keepsake,
            'message' => 'Keepsake created successfully! 💕'
        ]);
    }

    /**
     * Show a specific keepsake
     */
    public function show(Request $request, $id)
    {
        $keepsake = Keepsake::findOrFail($id);
        
        // Check if private and password protected
        if ($keepsake->is_private && $keepsake->password) {
            // Check if password provided in request
            if (!$request->filled('password') || !$keepsake->checkPassword($request->password)) {
                return response()->json([
                    'locked' => true,
                    'message' => 'This keepsake is password protected'
                ], 403);
            }
        }
        
        // Increment view count
        $keepsake->incrementViews();
        
        return response()->json([
            'keepsake' => [
                'id' => $keepsake->id,
                'title' => $keepsake->title,
                'description' => $keepsake->description,
                'memory_date' => $keepsake->memory_date->format('Y-m-d'),
                'formatted_date' => $keepsake->formatted_date,
                'category' => $keepsake->category,
                'category_details' => $keepsake->category_details,
                'mood' => $keepsake->mood,
                'tags' => $keepsake->tags,
                'image_url' => $keepsake->image_url,
                'is_favorite' => $keepsake->is_favorite,
                'is_private' => $keepsake->is_private,
                'created_by' => $keepsake->created_by,
                'view_count' => $keepsake->view_count,
            ]
        ]);
    }

    /**
     * Update a keepsake
     */
    public function update(Request $request, $id)
    {
        $keepsake = Keepsake::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'memory_date' => 'sometimes|required|date',
            'category' => 'sometimes|required|string',
            'mood' => 'nullable|string|max:20',
            'tags' => 'nullable|array',
            'image' => 'nullable|string',
            'is_favorite' => 'boolean',
            'is_private' => 'boolean',
            'password' => 'nullable|string|min:4',
        ]);
        
        // Handle new image upload
        if ($request->filled('image')) {
            // Delete old image if exists
            if ($keepsake->image_path) {
                Storage::disk('public')->delete($keepsake->image_path);
            }
            
            // Save new image (same logic as store)
            $imageData = $request->image;
            if (preg_match('/^data:image\/(\w+);base64,/', $imageData, $type)) {
                $imageData = substr($imageData, strpos($imageData, ',') + 1);
                $type = strtolower($type[1]);
                $imageData = base64_decode($imageData);
                $filename = 'keepsake_' . Str::uuid() . '.' . $type;
                Storage::disk('public')->put('keepsakes/' . $filename, $imageData);
                $validated['image_path'] = 'keepsakes/' . $filename;
                $validated['image_type'] = $type;
            }
        }
        
        $keepsake->update($validated);
        
        return response()->json([
            'success' => true,
            'keepsake' => $keepsake,
            'message' => 'Keepsake updated successfully! ✨'
        ]);
    }

    /**
     * Delete a keepsake
     */
    public function destroy($id)
    {
        $keepsake = Keepsake::findOrFail($id);
        
        // Delete associated image
        if ($keepsake->image_path) {
            Storage::disk('public')->delete($keepsake->image_path);
        }
        
        $keepsake->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Keepsake deleted successfully'
        ]);
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite($id)
    {
        $keepsake = Keepsake::findOrFail($id);
        $isFavorite = $keepsake->toggleFavorite();
        
        return response()->json([
            'success' => true,
            'is_favorite' => $isFavorite,
            'message' => $isFavorite ? 'Added to favorites! ⭐' : 'Removed from favorites'
        ]);
    }

    /**
     * Get calendar data
     */
    public function getCalendarData(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);
        
        // Get keepsakes for this month
        $startDate = "{$year}-{$month}-01";
        $endDate = date('Y-m-t', strtotime($startDate));
        
        $keepsakes = Keepsake::dateRange($startDate, $endDate)
            ->orderByDate()
            ->get()
            ->groupBy(function($keepsake) {
                return $keepsake->memory_date->format('Y-m-d');
            });
        
        return response()->json([
            'year' => $year,
            'month' => $month,
            'keepsakes' => $keepsakes
        ]);
    }

    /**
     * Export all keepsakes as JSON
     */
    public function export()
    {
        $keepsakes = Keepsake::orderByDate()->get();
        
        $export = $keepsakes->map(function($keepsake) {
            return [
                'title' => $keepsake->title,
                'description' => $keepsake->description,
                'memory_date' => $keepsake->memory_date->format('Y-m-d'),
                'category' => $keepsake->category,
                'mood' => $keepsake->mood,
                'tags' => $keepsake->tags,
                'image_url' => $keepsake->image_url,
                'is_favorite' => $keepsake->is_favorite,
                'created_by' => $keepsake->created_by,
                'created_at' => $keepsake->created_at->format('Y-m-d H:i:s'),
            ];
        });
        
        return response()->json([
            'keepsakes' => $export,
            'exported_at' => now()->format('Y-m-d H:i:s'),
            'total' => $export->count()
        ])
        ->header('Content-Disposition', 'attachment; filename="keepsakes_backup_' . date('Y-m-d') . '.json"');
    }
}