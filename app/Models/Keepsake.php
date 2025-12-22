<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

/**
 * Keepsake Model
 * Represents a love memory with photos, categories, and privacy settings
 */
class Keepsake extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'memory_date',
        'category',
        'mood',
        'tags',
        'image_path',
        'image_type',
        'is_favorite',
        'is_private',
        'password',
        'created_by',
        'view_count',
        'last_viewed_at'
    ];

    protected $casts = [
        'memory_date' => 'date',
        'tags' => 'array',
        'is_favorite' => 'boolean',
        'is_private' => 'boolean',
        'last_viewed_at' => 'datetime',
        'view_count' => 'integer'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Set password for private keepsake
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    /**
     * Check if provided password matches
     */
    public function checkPassword($password)
    {
        if (!$this->is_private || !$this->password) {
            return true;
        }
        
        return Hash::check($password, $this->password);
    }

    /**
     * Get formatted date for display
     */
    public function getFormattedDateAttribute()
    {
        return $this->memory_date->format('F j, Y');
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }
        
        // If it's a full URL (external)
        if (filter_var($this->image_path, FILTER_VALIDATE_URL)) {
            return $this->image_path;
        }
        
        // Local storage path
        return asset('storage/' . $this->image_path);
    }

    /**
     * Scope: Get only favorites
     */
    public function scopeFavorites($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Scope: Get by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Get by mood
     */
    public function scopeByMood($query, $mood)
    {
        return $query->where('mood', $mood);
    }

    /**
     * Scope: Search by keyword
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('title', 'LIKE', "%{$keyword}%")
              ->orWhere('description', 'LIKE', "%{$keyword}%");
        });
    }

    /**
     * Scope: Get keepsakes in date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('memory_date', [$startDate, $endDate]);
    }

    /**
     * Scope: Order by date (newest first by default)
     */
    public function scopeOrderByDate($query, $direction = 'desc')
    {
        return $query->orderBy('memory_date', $direction);
    }

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('view_count');
        $this->update(['last_viewed_at' => now()]);
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite()
    {
        $this->is_favorite = !$this->is_favorite;
        $this->save();
        return $this->is_favorite;
    }

    /**
     * Get keepsakes grouped by month
     */
    public static function getMonthlyStats($year = null)
    {
        $year = $year ?? now()->year;
        
        return self::selectRaw('MONTH(memory_date) as month, COUNT(*) as count')
            ->whereYear('memory_date', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();
    }

    /**
     * Get all available categories
     */
    public static function getCategories()
    {
        return [
            'first_date' => ['label' => 'First Date', 'emoji' => '💕'],
            'anniversary' => ['label' => 'Anniversary', 'emoji' => '🎉'],
            'trip' => ['label' => 'Trip/Vacation', 'emoji' => '✈️'],
            'date_night' => ['label' => 'Date Night', 'emoji' => '🌙'],
            'surprise' => ['label' => 'Surprise', 'emoji' => '🎁'],
            'milestone' => ['label' => 'Milestone', 'emoji' => '🏆'],
            'special_moment' => ['label' => 'Special Moment', 'emoji' => '⭐'],
            'just_because' => ['label' => 'Just Because', 'emoji' => '💝'],
        ];
    }

    /**
     * Get category details
     */
    public function getCategoryDetailsAttribute()
    {
        $categories = self::getCategories();
        return $categories[$this->category] ?? ['label' => $this->category, 'emoji' => '💖'];
    }
}