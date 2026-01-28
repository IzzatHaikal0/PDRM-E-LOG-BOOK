<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balai',
        'area',
        'type',
        'date',
        'time',
        'remarks',
        'officer_id',
        'end_time',
        'status',
        'rejection_reason',
    ];

    // Relationship: Who submitted this log?
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship: Who is the verifying officer?
    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}