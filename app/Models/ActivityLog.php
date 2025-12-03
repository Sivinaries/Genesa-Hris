<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'compani_id',
        'activity_type',
        'description',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function compani()
    {
        return $this->belongsTo(Compani::class);
    }

    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at?->format('d M Y, H:i');
    }

    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at?->diffForHumans();
    }
}
