<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GlobalPtkp extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'code',
        'amount',
        'ter_category',
    ];
}
