<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SyncAnnualDues extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','deleted_at','deleted_by','is_active','status',
        'annual_dues_id','pps_no','payment_dt','sync_date'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_sync_annual_dues';

    protected $fillable = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','deleted_at','deleted_by','is_active','status',
        'annual_dues_id','pps_no','payment_dt','sync_date'
    ];
}
