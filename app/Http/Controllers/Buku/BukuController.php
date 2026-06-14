<?php
namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $books = Buku::select(
            'id',
            'kode_buku',
            'judul',
            'pengarang',
            'penerbit',
            'isbn',
            'tahun_terbit',
            'stok_tersedia',
            'cover_buku',
            'status'
        )
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('pengarang', 'like', "%{$search}%")
                        ->orWhere('kode_buku', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('buku.index', compact('books', 'search'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_buku'        => 'required|unique:buku,kode_buku',
            'judul'            => 'required',
            'pengarang'        => 'required',
            'penerbit'         => 'required',
            'tahun_terbit'     => 'required|numeric',
            'kota_terbit'      => 'required',
            'bahasa'           => 'required',
            'jumlah_eksemplar' => 'required|numeric',
            'stok_tersedia'    => 'required|numeric',
            'cover_buku'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover_buku')) {
            $validated['cover_buku'] = $request
                ->file('cover_buku')
                ->store('cover-buku', 'public');
        }

        Buku::create($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil ditambahkan');
    }

    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }

    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kode_buku'        => 'required|unique:buku,kode_buku,' . $buku->id,
            'judul'            => 'required',
            'pengarang'        => 'required',
            'penerbit'         => 'required',
            'tahun_terbit'     => 'required|numeric',
            'kota_terbit'      => 'required',
            'bahasa'           => 'required',
            'jumlah_eksemplar' => 'required|numeric',
            'stok_tersedia'    => 'required|numeric',
            'cover_buku'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('cover_buku')) {

            if ($buku->cover_buku) {
                Storage::disk('public')->delete($buku->cover_buku);
            }

            $validated['cover_buku'] = $request
                ->file('cover_buku')
                ->store('cover-buku', 'public');
        }

        $buku->update($validated);

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover_buku) {
            Storage::disk('public')->delete($buku->cover_buku);
        }

        $buku->delete();

        return redirect()
            ->route('buku.index')
            ->with('success', 'Data buku berhasil dihapus');
    }
}
