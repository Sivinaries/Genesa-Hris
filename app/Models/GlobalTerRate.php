<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalTerRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'ter_category',     // 'A', 'B', 'C'
        'gross_income_min', // Batas Bawah Penghasilan
        'gross_income_max', // Batas Atas Penghasilan
        'rate_percentage',  // Tarif Persentase
    ];

    // Memastikan output angka tetap angka (bukan string)
    protected $casts = [
        'gross_income_min' => 'decimal:2',
        'gross_income_max' => 'decimal:2',
        'rate_percentage'  => 'float',
    ];

    public static function getRateFor($category, $grossIncome)
    {
        // Cari range dimana gaji bruto berada di antara min dan max
        $rate = self::where('ter_category', $category)
            ->where('gross_income_min', '<=', $grossIncome)
            ->where('gross_income_max', '>=', $grossIncome)
            ->first();

        return $rate ? $rate->rate_percentage : 0;
    }
}
