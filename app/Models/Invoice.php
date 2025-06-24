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
        'dealer_id',
        'user_id',
        'brand',
        'part_id',
        'description',
        'qty',
        'rate',
        'amount',
    ];
}
