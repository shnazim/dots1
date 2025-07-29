<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analytics extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_id',
        'report_type',
        'generated_at',
        'parameters',
        'data_summary',
        'execution_time',
        'user_id'
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'parameters' => 'array',
        'data_summary' => 'array',
        'execution_time' => 'decimal:3',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByReportType($query, $type)
    {
        return $query->where('report_type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('generated_at', '>=', now()->subDays($days));
    }

    public function scopeByBusiness($query, $businessId)
    {
        return $query->where('business_id', $businessId);
    }
} 