<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kecemasan extends Model
{
    use HasFactory;

    protected $table = 'contact_kecemasan';
    protected $fillable = ['name', 'no_telefon'];

}