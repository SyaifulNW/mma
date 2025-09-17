<?php
// app/Models/Task.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Task extends Model
{
    protected $table = 'tasks';
    protected $fillable = ['materi_id', 'nama'];

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
       public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function inisiatifs()
    {
        return $this->hasMany(Inisiatif::class, 'task_id');
    }

    public function sprints()
    {
        return $this->hasMany(Sprint::class);
    }
};


?>