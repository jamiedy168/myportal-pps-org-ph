<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Announcement extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'title', 'subtitle', 'content', 'cover_photo',
        'format', 'priority', 'audience', 'is_active',
        'is_pinned', 'is_public', 'publish_at', 'expires_at',
        'created_by', 'archived_by', 'archived_at', 'archive_reason',
    ];

    protected $casts = [
        'audience'    => 'array',
        'is_active'   => 'boolean',
        'is_pinned'   => 'boolean',
        'is_public'   => 'boolean',
        'publish_at'  => 'datetime',
        'expires_at'  => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function archiver()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                     ->where(function ($q) {
                         $q->whereNull('publish_at')
                           ->orWhere('publish_at', '<=', now());
                     })
                     ->where(function ($q) {
                         $q->whereNull('expires_at')
                           ->orWhere('expires_at', '>', now());
                     });
    }

    public function scopeForAudience($query, $memberType = null)
    {
        return $query->where(function ($q) use ($memberType) {
            $q->whereJsonContains('audience', 'all');
            if ($memberType) {
                $q->orWhereJsonContains('audience', strtolower($memberType));
            }
        });
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function getCoverPhotoUrlAttribute()
    {
        if (!$this->cover_photo) {
            return asset('assets/img/illustrations/pps-announcement-default.jpg');
        }
        return \Storage::disk('s3')->temporaryUrl(
            'announcements/' . $this->cover_photo,
            now()->addMinutes(60)
        );
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'urgent'    => '#DC3545',
            'important' => '#FFC107',
            default     => '#1B3A6B',
        };
    }

    public function getPriorityLabelAttribute()
    {
        return match($this->priority) {
            'urgent'    => '🚨 URGENT',
            'important' => '⚠️ IMPORTANT',
            default     => '📢 ANNOUNCEMENT',
        };
    }

    public function getFormatLabelAttribute()
    {
        return match($this->format) {
            'urgent'          => 'Emergency Alert',
            'event_reminder'  => 'Event Reminder',
            'policy_update'   => 'Policy Update',
            'congratulations' => 'Congratulations',
            default           => 'General Announcement',
        };
    }

    public function isVisibleTo($user = null)
    {
        if (in_array('all', (array) $this->audience)) return true;
        if (!$user) return $this->is_public;

        $memberType = optional(optional($user)->memberInfo)->type ?? null;

        return in_array(
            strtolower($memberType ?? ''),
            array_map('strtolower', (array) $this->audience)
        );
    }

    public function archive($userId, $reason = 'Superseded by new announcement')
    {
        $this->update([
            'is_active'      => false,
            'archived_by'    => $userId,
            'archived_at'    => now(),
            'archive_reason' => $reason,
        ]);
    }
}
