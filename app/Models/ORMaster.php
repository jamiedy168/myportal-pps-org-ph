<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ORMaster extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $auditInclude  = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','or_no','transaction_type',
        'transaction_id','discountable','vatable','amount','change','total_amount','pps_no','payment_dt','check_out_sessions_id',
        'payment_mode','temporary_checkout_session','bank_name','cheque_number','posting_dt','is_dollar','dollar_rate','dollar_conversion',
        'paymongo_payment_id'
        
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_or_master';

    protected $fillable = [
        'id','created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','or_no','transaction_type',
        'transaction_id','discountable','vatable','amount','change','total_amount','pps_no','payment_dt','check_out_sessions_id',
        'payment_mode','temporary_checkout_session','bank_name','cheque_number','posting_dt','is_dollar','dollar_rate','dollar_conversion',
        'paymongo_payment_id'
    ];
}
