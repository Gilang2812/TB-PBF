<?php

namespace App\Http\Controllers;

use App\Models\bookModel;
use App\Models\DetailTransactionModel;
use App\Models\PenerbitModel;
use App\Models\PosisiModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    public function dashboard()
    {
        $user = User::where('isAdmin', '!=', 1)->get();
        $book = bookModel::all();
        $transaksi = DetailTransactionModel::all();

        // return response()->json(array('user' => $transaksi));
        return view('dashboard', compact('user', 'book', 'transaksi'));
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = bookModel::query();

        if ($search) {
            $query->where('judul_buku', 'like', '%' . $search . '%');
        }

        $book = $query->get();

        return view('books.admin.index', compact('book'));
    }

    public function indexClient(Request $request)
    {
        $search = $request->input('search');
        $query = BookModel::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', '%' . $search . '%')
                    ->orWhere('nomor_buku', 'like', '%' . $search . '%')
                    ->orWhere('pengarang.pengarang', 'like', '%' . $search . '%')
                    ->orWhere('id_penerbit', 'like', '%' . $search . '%')
                    ->orWhere('ketersediaan', 'like', '%' . $search . '%');
            });
        }

        $book = $query->get();

        return view('books.user.index', compact('book'));
    }

    public function create()
    {
        $posisi = PosisiModel::all();
        $penerbit = PenerbitModel::all();
        return view('books.admin.create', compact('posisi', 'penerbit'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_buku' => 'required',
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'ketersediaan' => 'required|integer',
            'gambar_buku' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $buku = new BookModel();
        $buku->nomor_buku = $request->nomor_buku;
        $buku->id_posisi = $request->id_posisi;
        $buku->judul_buku = $request->judul_buku;
        $buku->id_penerbit = $request->id_penerbit;
        $buku->pengarang = $request->pengarang;
        $buku->ketersediaan = $request->ketersediaan;

        if ($request->hasFile('gambar_buku')) {
            $imagePath = $request->file('gambar_buku')->store('gambar_buku', 'public');
            $buku->image = $imagePath;
        }

        $buku->save();
        return response()->json(array('success' => $imagePath ?? ''));
        return Redirect::route('book.index');
    }


    public function edit($id)
    {
        $buku = bookModel::find($id);
        $posisi = PosisiModel::all();
        $penerbit = PenerbitModel::all();

        if (Auth::user()?->isAdmin === 1) {
            return view('books.admin.edit', compact('buku', 'posisi', 'penerbit'));
        } else {
            return view('books.user.show', compact('buku', 'posisi', 'penerbit'));
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomor_buku' => 'required',
            'judul_buku' => 'required',
            'ketersediaan' => 'required'
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $buku = bookModel::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('book.index')->with('success', 'Book updated successfully');
    }

    public function destroy($id)
    {
        $usedBook = DetailTransactionModel::where('nomor_buku', $id)->get();
        if ($usedBook) {
            return redirect()->route('book.index')->with('warning', 'Buku tidak bisa dihapus karena sudah digunakan');
        }

        //return response()->json(array('data' => $usedBook));
        $buku = bookModel::destroy($id);


        return redirect()->route('book.index');
    }
}
