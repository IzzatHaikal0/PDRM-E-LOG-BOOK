<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\table;

class Penugasan extends Model
{
    use HasFactory;

    protected $table = 'penugasan';
    protected $fillable = [
        'name',
        'category',
        'description',
    ];

    
}