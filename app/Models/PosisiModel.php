<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PosisiModel extends Model
{
    use HasFactory;

    protected $table = 'posisi';
    protected $primaryKey = 'id_posisi';
    public $timestamps = true;

    protected $fillable = [
        'nama_posisi'
    ];

    public function buku()
    {
        return $this->hasMany(bukuModel::class);
    }
}