<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\DendaModel;
use App\Models\bookModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DendaController extends Controller
{
    public function index()
    {
        $dendas = DendaModel::all();
        if (Auth::user()?->isAdmin==1){
        
            return view('denda.admin.index', compact('dendas'));
        }else{

            return view('denda.user.index', compact ('dendas'));
        }
    }

    public function create()
    {
        $users = user::all();
        return view('denda.admin.create',compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'denda' => 'required|numeric',
        ], [
            'required' => 'Kolom :attribute wajib diisi.'
        ]);
        
        $user = User::find($request->name);
        $user->dendas()->create([
            'nomor_buku' => $request->nomor_buku,
            'jenis_buku' => $request->jenis_buku,
            'pengarang' => $request->pengarang,
            'denda' => $request->denda,
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

        return redirect()->route('denda.admin.index')->with('success', 'Denda deleted successfully.');
    }
}
