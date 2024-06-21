<?php

namespace App\Http\Controllers;

use App\Models\DurasiModel;
use Illuminate\Http\Request;

class DurasiController extends Controller
{
    public function create(Request $request)
    {
        
        return view('durasi.admin.create');
    }

    public function store(Request $request)
    {

        $durasi = DurasiModel::all();
        $data = false;
        if ($durasi->isNotEmpty()) {
            return redirect()->back()->with('warning', 'Durasi sudah diatur sebelumnya. Silakan periksa kembali.');
        }
        $request->validate([
            'nama' => 'required',
            'durasi' => 'required|numeric'
        ]);

        DurasiModel::create($request->all());

        return redirect()->route('denda.index');
    }

    public function edit($id)
    {
        $durasi = DurasiModel::find($id);

        return view('durasi.admin.edit', compact('durasi'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama' =>'required',
            'durasi' =>'required|numeric'
        ]);

        $durasi = DurasiModel::find($id);
        $durasi->update($request->all());

        return redirect()->route('denda.index')->with('success', 'Durasi updated successfully.');
    }

    public function destroy($id){
        $durasi = DurasiModel::find($id);
        $durasi->delete();

        return redirect()->route('denda.index')->with('success', 'Durasi deleted successfully.');
    }
}
