<?php

namespace App\Http\Controllers;

use App\Models\DendaModel;
use App\Models\DetailTransactionModel;
use App\Models\DurasiModel;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    public function index()
    {
   
        $transaksi = DetailTransactionModel::all()->where('status', 0)->where('peminjaman.status', 1);
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

        // Retrieve or create the first DendaModel
        $denda = DendaModel::firstOrCreate([], ['nama'=>'tiga ribu','denda' => 3000]);
        $idDenda = $denda->id_denda;

        // Retrieve or create the first DurasiModel
        $durasi = DurasiModel::firstOrCreate([], ['durasi' => 7]);
        $idDurasi = $durasi->id_durasi;

        // Generate nomor_peminjaman
        $currentDate = now()->format('ymd');
        $randomNumber = mt_rand(1000, 9999);
        $nomorPeminjaman = $currentDate . $randomNumber;

        // Retrieve or create the first TransactionModel
        $transaksi = TransactionModel::firstOrCreate(
            ['id_user' => $userId, 'status' => 0],
            [
                'nomor_peminjaman' => $nomorPeminjaman,
                'id_denda' => $idDenda,
                'id_durasi' => $idDurasi
            ]
        );

        // Check if the book has already been borrowed
        if (DetailTransactionModel::where('nomor_peminjaman', $transaksi->nomor_peminjaman)
            ->where('nomor_buku', $id)
            ->exists()
        ) {
            Session::flash('warning', 'Anda sudah meminjam buku ini.');
            return redirect()->back();
        }

        // Create the detail transaction
        DetailTransactionModel::create([
            'nomor_peminjaman' => $transaksi->nomor_peminjaman,
            'nomor_buku' => $id
        ]);

        return redirect(route('pinjaman.index.user'));
    }


    public function update($id)
    {
        $transaksi = TransactionModel::find($id);
        $transaksi->update(['status' => 1]);

        return redirect(route('pinjaman.index.user'));
    }

    public function destroy($id)
    {
        $transaksi = TransactionModel::find($id);
        $transaksi->delete();

        return response()->json(array('transaksi' => $transaksi));
    }

    public function showAdmin(Request $request)
    {
    $status = $request->query('status');

    if ($status) {
        $transaksi = DetailTransactionModel::where('status', $status)->get();
    } else {
        $transaksi = DetailTransactionModel::where('status', '!=', '0')->get();
    }

    return view('transaction.admin.history', compact('transaksi'));
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
