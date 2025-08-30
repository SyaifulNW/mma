<?php
// app/Models/Tahapan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tahapan extends Model
{
    protected $table = 'tahapan';
    protected $fillable = ['materi_id', 'nama'];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'tahapan_id');
    }
}



?>