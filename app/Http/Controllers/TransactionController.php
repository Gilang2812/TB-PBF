<?php

namespace App\Http\Controllers;

use App\Models\DetailTransactionModel;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {

        return view('transaction.peminjaman');
    }
    public function store($id)
    {
        $transaksi = TransactionModel::where('id_user', Auth::id())
            ->where('status', 0)->get();
   ;
        $nomorPeminjaman = mt_rand(1000000000, 9999999999);
        if ($transaksi&&$transaksi->count() === 0) {
            $transaksi = TransactionModel::create([
                'nomor_peminjaman' => (string)$nomorPeminjaman,
                'id_user' => Auth::id(),
                'status' => 0
            ]);
        }

        $detailPeminjaman = DetailTransactionModel::create([
         'nomor_peminjaman' => $transaksi->first()->nomor_peminjaman,
         'nomor_buku']);   

        return response()->json(array('transaksi' => Auth::id(), 'id_user' => $nomorPeminjaman, 'datas' => $transaksi->first()));
    }
}
