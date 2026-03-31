<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;


class CertificateMaintenance extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
   
    protected $auditInclude  = [
        'created_at', 'created_by', 'updated_at', 'updated_by','is_active','status','event_id',
        'document_id','original_file_name','file_name','file_type','file_size','upload_dt',
        'name_font_size','name_font_color','name_horizontal','cpd_font_size','cpd_font_color',
        'cpd_horizontal','cpd_vertical'
    ];

    protected $connection = 'pgsql';
    protected $table = 'tbl_certificate_maintenance';

}
