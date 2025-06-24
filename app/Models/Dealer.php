<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dealer extends Model
{
    use HasFactory;
    protected $fillable = [
        'dealer_code',
        'dealer_name',
        'status',
    ];
}
