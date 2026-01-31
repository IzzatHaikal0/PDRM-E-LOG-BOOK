<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangkat extends Model
{
    use HasFactory;

    protected $fillable = ['pangkat_name'];

    // Relationship: One Pangkat has many Users
    public function users()
    {
        return $this->hasMany(User::class, 'pangkat_id', 'id');
    }
}