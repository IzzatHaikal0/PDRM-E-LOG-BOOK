<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Laravel\Prompts\table;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penugasan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'penugasan';
    protected $fillable = [
        'name',
        'category',
        'description',
    ];

    
}