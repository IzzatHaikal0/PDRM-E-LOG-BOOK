<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pangkat extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['pangkat_name', 'level'];

    // Relationship: One Pangkat has many Users
    public function users()
    {
        return $this->hasMany(User::class, 'pangkat_id', 'id');
    }
}