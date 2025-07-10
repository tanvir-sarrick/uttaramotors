<?php

namespace App\Models;

use App\Models\Dealer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function dealer()
    {
        return $this->belongsTo(Dealer::class);
    }
}
