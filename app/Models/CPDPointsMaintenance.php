<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CPDPointsMaintenance extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'tbl_cpd_points_maintenance';
}
