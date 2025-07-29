<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class IntegrationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'platform',
        'name',
        'credentials',
        'settings',
        'is_active',
        'last_sync_at',
        'expires_at',
    ];

    protected $casts = [
        'credentials' => 'encrypted:array',
        'settings' => 'array',
        'is_active' => 'boolean',
        'last_sync_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the integration setting.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the decrypted credentials.
     */
    public function getDecryptedCredentials()
    {
        return $this->credentials;
    }

    /**
     * Set encrypted credentials.
     */
    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Check if the integration is expired (for OAuth tokens).
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the integration needs refresh (for OAuth tokens).
     */
    public function needsRefresh()
    {
        return $this->expires_at && $this->expires_at->subMinutes(30)->isPast();
    }

    /**
     * Get platform display name.
     */
    public function getPlatformDisplayName()
    {
        $platforms = [
            'quickbooks' => 'QuickBooks Online',
            'sap' => 'SAP Business One',
            'xero' => 'Xero',
            'dynamics' => 'Microsoft Dynamics 365',
            'netsuite' => 'Oracle NetSuite',
        ];

        return $platforms[$this->platform] ?? ucfirst($this->platform);
    }

    /**
     * Get platform icon class.
     */
    public function getPlatformIcon()
    {
        $icons = [
            'quickbooks' => 'fab fa-quickbooks text-primary',
            'sap' => 'fas fa-chart-line text-success',
            'xero' => 'fas fa-cloud text-info',
            'dynamics' => 'fab fa-microsoft text-primary',
            'netsuite' => 'fas fa-database text-warning',
        ];

        return $icons[$this->platform] ?? 'fas fa-plug text-secondary';
    }

    /**
     * Scope to get active integrations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get integrations by platform.
     */
    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }
} 