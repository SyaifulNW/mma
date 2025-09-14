<?php
// app/Models/Materi.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi';
    protected $fillable = ['kode', 'nama'];

   
    public function tasks()
    {
        return $this->hasMany(Task::class, 'materi_id');
    }
}
?>