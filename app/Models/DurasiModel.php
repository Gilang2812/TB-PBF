<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurasiModel extends Model
{
    use HasFactory;
    protected $table = 'posisi';
    protected $primaryKey = 'id_posisi';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'durasi'
    ];

    public function buku()
    {
        return $this->hasMany(bookModel::class);
    }
}
