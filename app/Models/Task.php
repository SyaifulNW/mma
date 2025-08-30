<?php
// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['materi_id', 'tahapan_id', 'nama'];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function tahapan()
    {
        return $this->belongsTo(Tahapan::class, 'tahapan_id');
    }

    public function inisiatif()
    {
        return $this->hasMany(Inisiatif::class, 'task_id');
    }
}


?>