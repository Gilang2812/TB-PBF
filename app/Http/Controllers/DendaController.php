<?php

namespace App\Http\Controllers;

use App\Models\DendaModel;
use App\Models\DurasiModel;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $denda = DendaModel::first();
        $durasi = DurasiModel::first();
    //    return response()->json(array('denda' =>$denda, 'urasi' =>$durasi));
        return view('denda.admin.index', compact('denda', 'durasi'));
    }

    public function create()
    {

        return view('denda.admin.create');
    }

    public function store(Request $request)
    {

        $denda = DendaModel::all();

        if ($denda->isNotEmpty()){
            return redirect()->route('denda.index')->with('warning', 'Denda sudah tersedia');
        }
        $request->validate([
            'nama' => 'required',
            'denda' => 'required|numeric',
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        DendaModel::create($request->all());
        return redirect()->back()->with('success', 'Denda berhasil ditambahkan');
    }

    public function edit($id)
    {
        $denda = DendaModel::find($id);
        return view('denda.admin.edit', compact('denda'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'denda' => 'required|numeric',
        ]);

        $denda = DendaModel::find($id);
        $denda->update($request->all());

        return redirect()->route('denda.admin.index')->with('success', 'Denda updated successfully.');
    }

    public function destroy($id)
    {
        $denda = DendaModel::find($id);
        $denda->delete();

        return redirect()->route('denda.index')->with('success', 'Denda deleted successfully.');
    }
}
