<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;
  protected $fillable = [
        'task_id',
        'inisiatif_id',
        'mulai',
        'selesai',
        'status',
         'created_by'
    ];

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    // Relasi ke Inisiatif
    public function inisiatif()
    {
        return $this->belongsTo(Inisiatif::class);
    }
    public function creator()
{
    return $this->belongsTo(User::class, 'created_by');
}

}
