<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'reviewed_by', 'month', 'year',
        'sales_score', 'attendance_score', 'task_completion',
        'customer_rating', 'overall_score', 'rating',
        'feedback', 'areas_of_improvement', 'top_performer',
    ];

    protected $casts = [
        'top_performer' => 'boolean',
        'sales_score' => 'decimal:2',
        'attendance_score' => 'decimal:2',
        'task_completion' => 'decimal:2',
        'customer_rating' => 'decimal:2',
        'overall_score' => 'decimal:2',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(\App\Models\User::class, 'reviewed_by');
    }

    // Auto-compute overall score before save
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($review) {
            $review->overall_score = round(
                ($review->sales_score + $review->attendance_score +
                 $review->task_completion + $review->customer_rating) / 4, 2
            );
            // Auto-assign rating
            $review->rating = match(true) {
                $review->overall_score >= 90 => 'outstanding',
                $review->overall_score >= 80 => 'excellent',
                $review->overall_score >= 65 => 'good',
                $review->overall_score >= 50 => 'fair',
                default => 'poor',
            };
        });
    }

    public function getRatingColorAttribute()
    {
        return match($this->rating) {
            'outstanding' => 'emerald',
            'excellent' => 'green',
            'good' => 'blue',
            'fair' => 'yellow',
            'poor' => 'red',
            default => 'gray',
        };
    }
}
