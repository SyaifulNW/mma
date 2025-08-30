<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentee extends Model
{
    use HasFactory;
    protected $table = 'mentees';
    protected $fillable = ['nama', 'level', 'wa', 'kota'];


}

