<?php

namespace App\Http\Controllers\Buku;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('buku.index', [
            'search' => $search,
            'books' => Buku::select('id', 'kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'stok_tersedia', 'status')
                ->when($search !== '', function ($query) use ($search): void {
                    $query->where(function ($query) use ($search): void {
                        $query->where('judul', 'like', "%{$search}%")
                            ->orWhere('pengarang', 'like', "%{$search}%")
                            ->orWhere('kode_buku', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(10)
                ->withQueryString(),
        ]);
    }
}
