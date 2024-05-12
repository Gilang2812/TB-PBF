<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookModel extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $primaryKey = 'nomor_buku';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'nomor_buku',
        'id_posisi',
        'judul_buku',
        'id_penerbit',
        'pengarang',
        'ketersediaan'
    ];
    public $timestamps = true;
    public function posisi()
    {
        return $this->belongsTo(PosisiModel::class, 'id_posisi', 'id_posisi');
    }
    public function penerbit()
    {
        return $this->belongsTo(PenerbitModel::class, 'id_penerbit', 'id_penerbit');
    }
}
