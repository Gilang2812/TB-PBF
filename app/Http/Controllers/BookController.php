<?php

namespace App\Http\Controllers;

use App\Models\bookModel;
use App\Models\PenerbitModel;
use App\Models\PosisiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = bookModel::query();

        if ($search) {
            $query->where('judul_buku', 'like', '%' . $search . '%');
        }

        $book = $query->get();

        if (Auth::user()?->isAdmin === 1) {
            return view('books.admin.index', compact('book'));
        } else {
            return view('books.user.index', compact('book'));
        }
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
            'ketersediaan' => 'required'
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $buku = new bookModel();
        $buku->nomor_buku = $request->nomor_buku;
        $buku->id_posisi = $request->id_posisi;
        $buku->judul_buku = $request->judul_buku;
        $buku->id_penerbit = $request->id_penerbit;
        $buku->pengarang = $request->pengarang;
        $buku->ketersediaan = $request->ketersediaan;

        $buku->save();

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
        $buku = bookModel::find($id);
        $buku->delete();
        return redirect()->route('book.index');
    }
}
