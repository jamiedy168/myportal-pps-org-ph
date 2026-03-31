<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class ChecklistDocuments extends Model implements Auditable
{
    

    use HasFactory;
    use \OwenIt\Auditing\Auditable;
   
    protected $auditInclude  = [
        'created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','pps_no','document_id','original_file_name','file_name','file_type','file_size','upload_dt'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_checklist_documents';

    protected $dates = ['created_at',
    'upload_dt'];
}
