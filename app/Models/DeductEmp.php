<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeductEmp extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'employee_id',
        'deduct_id',
        'amount',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function deduct()
    {
        return $this->belongsTo(Deduct::class);
    }
}
