<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primaryKey = 'nomor_peminjaman';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nomor_peminjaman',
        'id_user',
        'id_durasi',
        'id_denda',
        'tanggal_peminjaman',
        'status'    
        ];
        
        public $timestamps = true;
        public function user()
        {
            return $this->belongsTo(User::class, 'id_user', 'id');
        }

        public function durasi()
        {
            return $this->belongsTo(DurasiModel::class, 'id_durasi', 'id_durasi');
        }

        public function denda()
        {
            return $this->belongsTo(DendaModel::class, 'id_denda', 'id_denda');
        }

        public function detail()
        {
            return $this->hasMany(DetailTransactionModel::class, 'nomor_peminjaman', 'nomor_peminjaman');
        }
}
