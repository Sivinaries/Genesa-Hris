<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'compani_id',
        'employee_id',
        'attendance_date',
        'clock_in',
        'clock_out',
        'status',
    ];

    public function compani()
    {
        return $this->belongsTo(Compani::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
