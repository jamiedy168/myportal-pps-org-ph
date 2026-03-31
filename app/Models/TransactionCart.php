<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionCart extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'tbl_transaction_cart';
}
