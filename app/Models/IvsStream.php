<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Carbon\Carbon;

class IvsStream extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'ivs_streams';

    protected $fillable = [
        'name',
        'button_label',
        'ivs_url',
        'status',
        'starts_at',
        'ends_at',
        'allowed_types',
        'allow_vip',
        'allow_all_members',
        'allow_admin',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status'            => 'boolean',
        'allow_vip'         => 'boolean',
        'allow_all_members' => 'boolean',
        'allow_admin'       => 'boolean',
        'allowed_types'     => 'array',
        'starts_at'         => 'datetime',
        'ends_at'           => 'datetime',
    ];

    /**
     * Is this stream currently live?
     * status must be true AND current time must be within starts_at/ends_at window.
     */
    public function isLive(): bool
    {
        if (!$this->status) {
            return false;
        }
        $now = Carbon::now('Asia/Manila');
        if ($this->starts_at &&
            $now->lt($this->starts_at->copy()->setTimezone('Asia/Manila'))) {
            return false;
        }
        if ($this->ends_at &&
            $now->gt($this->ends_at->copy()->setTimezone('Asia/Manila'))) {
            return false;
        }
        return true;
    }

    /**
     * Is this stream coming soon?
     * status=true but starts_at is in the future.
     */
    public function isComingSoon(): bool
    {
        if (!$this->status) {
            return false;
        }
        $now = Carbon::now('Asia/Manila');
        return $this->starts_at &&
            $now->lt($this->starts_at->copy()->setTimezone('Asia/Manila'));
    }

    /**
     * Can a given user watch this stream?
     */
    public function canUserWatch(\App\Models\User $user): bool
    {
        if ($user->role_id === 1 && $this->allow_admin) {
            return true;
        }

        $memberInfo = \DB::table('tbl_member_info')
            ->where('pps_no', $user->pps_no)
            ->first();

        if (!$memberInfo) {
            return false;
        }

        if ($this->allow_all_members) {
            return true;
        }

        if ($this->allow_vip && !empty($memberInfo->vip)) {
            return true;
        }

        $allowedTypes = is_array($this->allowed_types) ? $this->allowed_types : [];
        return in_array($memberInfo->member_type, $allowedTypes, true);
    }
}
