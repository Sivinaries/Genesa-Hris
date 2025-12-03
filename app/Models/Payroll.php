<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payroll extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'compani_id',
        'employee_id',
        'pay_period_start',
        'pay_period_end',
        'base_salary',
        'total_allowances',
        'total_deductions',
        'net_salary',
        'status',
        'payment_date',
    ];

    public function compani()
    {
        return $this->belongsTo(Compani::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payrollDetails()
    {
        return $this->hasMany(PayrollDetail::class);
    }
}
