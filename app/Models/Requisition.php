<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requisition extends Model
{
    use HasFactory;

    protected $fillable = [
        'requisition_id',
        'inventory_id',
        'name',
        'quantity',
        'department',
        'status',
        'release_date',
        'recommending_status',
        'approval_status'
    ];
}
