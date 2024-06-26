<?php

namespace App\Http\Controllers;

use App\Models\bookModel;
use App\Models\DetailTransactionModel;
use Carbon\Carbon;
 
class DetailTransactionController extends Controller
{
    public function cancelAction($nomor_buku, $nomor_peminjaman)
    {
        $detail = DetailTransactionModel::where('nomor_buku', $nomor_buku)->where('nomor_peminjaman', $nomor_peminjaman)->first();
        $detail->delete();
        return redirect()->route('pinjaman.index.user');
    }

    public function acceptRequest($nomor_peminjaman, $nomor_buku)
    {
        $detail = DetailTransactionModel::where('nomor_buku', $nomor_buku)->where('nomor_peminjaman', $nomor_peminjaman)->first();
        $detail->status = 1;
        $detail->save();
        return back();
    }

    public function rejectRequest($nomor_peminjaman, $nomor_buku)
    {
        $detail = DetailTransactionModel::where('nomor_buku', $nomor_buku)->where('nomor_peminjaman', $nomor_peminjaman)->first();


        $detail->status = 2;
        $detail->save();
        return back();
    }

    public function returnRequest($nomor_peminjaman, $nomor_buku)
    {
        $detail = DetailTransactionModel::where('nomor_buku', $nomor_buku)
            ->where('nomor_peminjaman', $nomor_peminjaman)
            ->firstOrFail();
        $detail->tanggal_pengembalian = now();
        $tanggalPeminjaman = Carbon::parse($detail->peminjaman->tanggal_peminjaman);
        $tanggalPeminjamanPlus3 = $tanggalPeminjaman->addDays(3);
        $detail->status = now()->greaterThan($tanggalPeminjamanPlus3) ? 3 : 4;

        $book = bookModel::where('nomor_buku', $nomor_buku)->first();
        if ($book) {
            $book->ketersediaan += 1;
            $book->save();
        }

        return back();
    }

    public function finishRequest($nomor_peminjaman, $nomor_buku)
    {
        $detail = DetailTransactionModel::where('nomor_buku', $nomor_buku)
            ->where('nomor_peminjaman', $nomor_peminjaman)
            ->firstOrFail();
        $detail->tanggal_pengembalian = now();
        $detail->status = 4;
        $detail->save();
        return back();
    }
}
