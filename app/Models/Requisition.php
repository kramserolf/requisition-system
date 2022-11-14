<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
       'inventory_id',
        'name',
       'quantity',
        'quantity_type',
        'department',
        'status',
        'recommending_status',
        'approval_status'
    ];
}
