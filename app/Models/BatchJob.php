<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchJob extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'name',
        'description',
        'template_id',
        'status',
        'file_path',
        'total_documents',
        'processed_documents',
        'failed_documents',
        'data',
        'generated_documents',
        'errors',
        'zip_url',
        'started_at',
        'completed_at'
    ];

    protected $casts = [
        'data' => 'array',
        'generated_documents' => 'array',
        'errors' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    /**
     * Get the user that owns the batch job
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the template used for this batch job
     */
    public function template()
    {
        return $this->belongsTo(DocumentTemplate::class, 'template_id');
    }

    /**
     * Get the progress percentage
     */
    public function getProgressPercentageAttribute()
    {
        if ($this->total_documents === 0) {
            return 0;
        }
        return round(($this->processed_documents / $this->total_documents) * 100);
    }

    /**
     * Get the status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'bg-yellow-100 text-yellow-800';
            case 'ready':
                return 'bg-blue-100 text-blue-800';
            case 'processing':
                return 'bg-purple-100 text-purple-800';
            case 'completed':
                return 'bg-green-100 text-green-800';
            case 'failed':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    /**
     * Get the status icon
     */
    public function getStatusIconAttribute()
    {
        switch ($this->status) {
            case 'pending':
                return 'clock';
            case 'ready':
                return 'check-circle';
            case 'processing':
                return 'cog';
            case 'completed':
                return 'check-circle';
            case 'failed':
                return 'x-circle';
            default:
                return 'question-mark-circle';
        }
    }

    /**
     * Get the type badge class
     */
    public function getTypeBadgeClassAttribute()
    {
        switch ($this->type) {
            case 'invoice':
                return 'bg-blue-100 text-blue-800';
            case 'quotation':
                return 'bg-green-100 text-green-800';
            case 'estimate':
                return 'bg-yellow-100 text-yellow-800';
            case 'po':
                return 'bg-purple-100 text-purple-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    /**
     * Get the type display name
     */
    public function getTypeDisplayNameAttribute()
    {
        switch ($this->type) {
            case 'invoice':
                return 'Invoice';
            case 'quotation':
                return 'Quotation';
            case 'estimate':
                return 'Estimate';
            case 'po':
                return 'Purchase Order';
            default:
                return ucfirst($this->type);
        }
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for recent jobs
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Check if job is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if job is failed
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }

    /**
     * Check if job is processing
     */
    public function isProcessing()
    {
        return $this->status === 'processing';
    }

    /**
     * Check if job is ready
     */
    public function isReady()
    {
        return $this->status === 'ready';
    }

    /**
     * Get success rate
     */
    public function getSuccessRateAttribute()
    {
        if ($this->total_documents === 0) {
            return 0;
        }
        return round((($this->total_documents - $this->failed_documents) / $this->total_documents) * 100);
    }
} 