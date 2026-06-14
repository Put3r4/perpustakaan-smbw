<?php
namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use App\Models\RakBuku;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RakBukuController extends Controller
{
    public function index(): View
    {
        $rak = RakBuku::withCount('buku')->latest()->paginate(10);

        return view('rak.index', compact('rak'));
    }

    public function create(): View
    {
        return view('rak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rak' => 'required',
            'nama_rak' => 'required',
            'lokasi'   => 'nullable',
        ]);

        RakBuku::create($request->all());

        return redirect()->route('buku.rak.index')
            ->with('success', 'Rak berhasil ditambahkan');
    }

    public function edit(RakBuku $rak): View
    {
        return view('rak.edit', compact('rak'));
    }

    public function update(Request $request, RakBuku $rak)
    {
        $request->validate([
            'kode_rak' => 'required',
            'nama_rak' => 'required',
            'lokasi'   => 'nullable',
        ]);

        $rak->update($request->all());

        return redirect()->route('buku.rak.index')
            ->with('success', 'Rak berhasil diupdate');
    }

    public function destroy(RakBuku $rak)
    {
        $rak->delete();

        return redirect()->route('buku.rak.index')
            ->with('success', 'Rak berhasil dihapus');
    }
}
