<?php
// app/Models/Inisiatif.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inisiatif extends Model
{
    protected $table = 'inisiatifs';
    protected $fillable = ['task_id', 'judul', 'dokumen', 'status'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}

?>