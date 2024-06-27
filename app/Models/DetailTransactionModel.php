<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 

class DetailTransactionModel extends Model
{
    use HasFactory;

    protected $table = 'detail_peminjaman'; // Specify the table name

    public $incrementing = false; // Disable incrementing primary key
    protected $primaryKey = ['nomor_peminjaman', 'nomor_buku']; // Composite key

    protected $fillable = [
        'nomor_peminjaman',
        'nomor_buku',
        'tanggal_pengembalian',
        'status'
    ];

    /**
     * Get the primary key for the model.
     *
     * @return array
     */
    public function getKeyName()
    {
        return $this->primaryKey;
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        foreach ($keys as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }

        return $query;
    }

    public function buku()
    {
        return $this->belongsTo(bookModel::class, 'nomor_buku', 'nomor_buku');
    }

    public function peminjaman()
    {
        return $this->belongsTo(TransactionModel::class, 'nomor_peminjaman', 'nomor_peminjaman');
    }
}
