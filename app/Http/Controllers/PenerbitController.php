<?php

namespace App\Http\Controllers;

use App\Models\PenerbitModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PenerbitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = PenerbitModel::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $penerbit = $query->get();

        return view('penerbit.admin.index', compact('penerbit'));
    }

    public function create()
    {
        return view('penerbit.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_penerbit' => 'required',
            'nama' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penerbit = new PenerbitModel();
        $penerbit->id_penerbit = $request->id_penerbit;
        $penerbit->nama = $request->nama;

        $penerbit->save();

        return Redirect::route('penerbit.index');
    }

    public function edit($id)
    {
        $penerbit = PenerbitModel::find($id);

        return view('penerbit.edit', compact('penerbit'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_penerbit' => 'required',
            'nama' => 'required',
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penerbit = PenerbitModel::findOrFail($id);
        $penerbit->update($request->all());

        return redirect()->route('penerbit.index')->with('success', 'Penerbit updated successfully');
    }

    public function destroy($id)
    {
        $penerbit = PenerbitModel::find($id);
        $penerbit->delete();

        return redirect()->route('penerbit.index');
    }
}
