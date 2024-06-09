<?php

namespace App\Http\Controllers;

use App\Models\DetailTransactionModel;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transaksi = DetailTransactionModel::with('peminjaman')
            ->whereHas('peminjaman', function ($query) {
                $query->where('status', 1);
            })->get();
        $transaksiUnik = $transaksi->unique('peminjaman.id_user');
        $responseData = [
            'user' => $transaksiUnik,
            'transaksi' => $transaksi,
        ];

        return view('transaction.admin.peminjaman', compact('responseData'));
        return response()->json(array('user' => $responseData['user'], 'test' => $transaksi));
    }

    public function indexClient()
    {


        $transaksi = DetailTransactionModel::with('buku')
            ->whereHas('peminjaman', function ($query) {
                $query->where('id_user', Auth::id());
                $query->where('status', 0);
            })
            ->get();

        return view('transaction.user.peminjaman', compact('transaksi'));
    }
    public function store($id)
    {
        $transaksi = TransactionModel::where('id_user', Auth::id())
            ->where('status', 0)->get();;


        $nomorPeminjaman = mt_rand(1000000000, 9999999999);

        if ($transaksi->isEmpty()) {
            $transaksi = TransactionModel::create([
                'nomor_peminjaman' => (string)$nomorPeminjaman,
                'id_user' => Auth::id(),
                'status' => 0
            ]);
        } else {
            $transaksi = $transaksi->first();
        }


        $detailPeminjaman = DetailTransactionModel::create([
            'nomor_peminjaman' => $transaksi->nomor_peminjaman,
            'nomor_buku' => $id
        ]);

        return redirect(route('pinjaman.index.user'));
        return response()->json(array('transaksi' => Auth::id(), 'id_user' => $nomorPeminjaman, 'datas' => $transaksi));
    }

    public function update($id)
    {
        $transaksi = TransactionModel::find($id);
        $transaksi->update(['status' => 1]);

        return response()->json(array('transaksi' => $transaksi));
    }
}
