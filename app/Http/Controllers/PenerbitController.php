<?php

namespace App\Http\Controllers;

use App\Models\PenerbitModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PenerbitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = PenerbitModel::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhereHas('buku', function ($query) use ($search) {
                      $query->where('judul_buku', 'like', '%' . $search . '%');
                  });
        }

        $penerbit = $query->with('buku')->get();

        if (Auth::user()?->isAdmin === 1) {
            return view('penerbit.admin.index', compact('penerbit'));
        } else {
            return view('penerbit.user.index', compact('penerbit'));
        }
    }

    // Metode lainnya tetap sama

    


    public function create()
    {
        return view('penerbit.admin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penerbit = new PenerbitModel();
        $penerbit->nama = $request->nama;

        $penerbit->save();

        return Redirect::route('penerbit.index')->with('success', 'Penerbit berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penerbit = PenerbitModel::find($id);

        return view('penerbit.admin.edit', compact('penerbit'));
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required',
    ], [
        'required' => 'Kolom :attribute wajib diisi.'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $penerbit = PenerbitModel::findOrFail($id);
    $penerbit->update($request->all());

    return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil diperbarui');
}

public function destroy($id)
{
    $penerbit = PenerbitModel::findOrFail($id);
    $penerbit->delete();

    return redirect()->route('penerbit.index')->with('success', 'Penerbit berhasil dihapus');
}

}
