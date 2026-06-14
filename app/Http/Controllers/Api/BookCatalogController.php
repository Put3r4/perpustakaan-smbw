<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookCatalogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = $request->string('search')->trim()->toString();

        $books = Buku::select('id', 'kode_buku', 'judul', 'pengarang', 'penerbit', 'tahun_terbit', 'stok_tersedia', 'status')
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('judul', 'like', "%{$search}%")
                        ->orWhere('pengarang', 'like', "%{$search}%")
                        ->orWhere('kode_buku', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12);

        return response()->json($books);
    }
}
