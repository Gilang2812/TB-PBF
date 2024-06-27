<?php

namespace App\Http\Controllers;

use App\Models\bookModel;
use App\Models\DendaModel;
use App\Models\DetailTransactionModel;
use App\Models\DurasiModel;
use App\Models\TransactionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

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
        //  return response()->json(array('user' => $responseData['user'], 'test' => $transaksi));
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
        $book = bookModel::where('nomor_buku', $id)->first();

        // Retrieve or create the first DendaModel
        $denda = DendaModel::firstOrCreate([], ['nama' => 'tiga ribu', 'denda' => 3000]);
        $idDenda = $denda->id_denda;

        // Retrieve or create the first DurasiModel
        $durasi = DurasiModel::firstOrCreate([], ['nama' => 'tujuh hari', 'durasi' => 7]);
        $idDurasi = $durasi->id_durasi;

        if ($book->ketersediaan == 0) {
            return back()->white('warnimg', ' tidak  yang tersedia untuk di pinjam ');
        }
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
        $detail = DetailTransactionModel::create([
            'nomor_peminjaman' => $transaksi->nomor_peminjaman,
            'nomor_buku' => $id
        ]);


        if ($book) {
            $book->ketersediaan -= 1;
            $book->save();
        }

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
        return redirect(route('pinjaman.index.user'));
       // return response()->json(array('transaksi' => $transaksi));
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

public function showUser(Request $request)
{
    $status = $request->query('status');
    $deadline = $request->query('deadline');

    $transaksiQuery = DetailTransactionModel::whereHas('peminjaman', function ($query) {
        $query->where('id_user', Auth::id())
              ->where('status', 1);
    });

    if ($status !== null) {
        $transaksiQuery->where('status', $status);
    } elseif ($deadline) {
        // Ambil semua transaksi yang statusnya 1
        $transaksi = $transaksiQuery->where('status', 1)->get();

        $transaksi = $transaksi->filter(function($transaksi) {
            $tanggalPeminjaman = Carbon::parse($transaksi->peminjaman->tanggal_peminjaman);
            $durasi = $transaksi->peminjaman->durasi->durasi ?? 7; // Nilai default 7 jika durasi tidak tersedia
            return $tanggalPeminjaman->addDays($durasi)->isToday();
        });

        return view('transaction.user.history', compact('transaksi'));
    } else {
        $transaksiQuery->where('status', '!=', '0');
    }

    $transaksi = $transaksiQuery->get();

    return view('transaction.user.history', compact('transaksi'));
}


}
