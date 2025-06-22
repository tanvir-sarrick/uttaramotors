<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'sl_no',
        'invoice_number',
        'brand',
        'part_id',
        'description',
        'qty',
        'rate',
        'amount',
    ];
}
