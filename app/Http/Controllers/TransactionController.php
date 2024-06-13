<?php

namespace App\Http\Controllers;

use App\Models\DetailTransactionModel;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{
    public function index()
    {
        $transaksi = DetailTransactionModel::with('peminjaman')
            ->whereHas('peminjaman', function ($query) {
                $query->where('status', 1);
            })->get();
        $transaksiUnik = $transaksi->unique('nomor_peminjaman',);
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
        $userId = Auth::id();
        $nomorPeminjaman = (string)mt_rand(1000000000, 9999999999);

        // Fetch the existing transaction or create a new one
        $transaksi = TransactionModel::firstOrCreate(
            ['id_user' => $userId, 'status' => 0],
            ['nomor_peminjaman' => $nomorPeminjaman]
        );

        // Check if the book has already been borrowed
        if (DetailTransactionModel::where('nomor_peminjaman', $transaksi->nomor_peminjaman)
            ->where('nomor_buku', $id)
            ->exists()) {
            Session::flash('warning', 'Anda sudah meminjam buku ini.');
            return redirect()->back();
        }

        // Create the detail transaction
        DetailTransactionModel::create([
            'nomor_peminjaman' => $transaksi->nomor_peminjaman,
            'nomor_buku' => $id
        ]);

        // Redirect to the user loan page
        return redirect(route('pinjaman.index.user'));
    }

    public function update($id)
    {
        $transaksi = TransactionModel::find($id);
        $transaksi->update(['status' => 1]);

        return response()->json(array('transaksi' => $transaksi));
    }

    public function destroy($id)
    {
        $transaksi = TransactionModel::find($id);
        $transaksi->delete();

        return response()->json(array('transaksi' => $transaksi));
    }

    public function showAdmin()
    {

        return view('transaction.admin.history');
    }

    public function showUser()
    {

        $transaksi = DetailTransactionModel::with('peminjaman')
            ->whereHas('peminjaman', function ($query) {
                $query->where('id_user', Auth::id());
                $query->where('status', '!=', 0);
            })->get();



        return view('transaction.user.history', compact('transaksi'));
    }
}
