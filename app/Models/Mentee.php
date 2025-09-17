<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mentee extends Model
{
    use HasFactory;
    protected $table = 'mentees';
    protected $fillable = ['user_id','nama', 'level', 'wa', 'kota',   'created_by',];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        



    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}


}

