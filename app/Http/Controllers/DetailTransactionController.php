<?php

namespace App\Http\Controllers;

use App\Models\DetailTransactionModel;
use Illuminate\Http\Request;

class DetailTransactionController extends Controller
{
    public function cancelAction($nomor_buku, $nomor_peminjaman){
        $detail = DetailTransactionModel::where('nomor_buku', $nomor_buku)->where('nomor_peminjaman', $nomor_peminjaman)->first();
        $detail->delete();
        return redirect()->route('pinjaman.index.user');
    }
}
