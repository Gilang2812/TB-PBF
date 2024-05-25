<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DendaModel extends Model
{
    use HasFactory;
    protected $table = 'denda';
    protected $primaryKey = 'id_posisi';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'denda'
    ];

    public function buku()
    {
        return $this->hasMany(bookModel::class);
    }
}
