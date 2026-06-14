<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AnggotaNonPelajar;
use App\Models\AnggotaPelajar;
use App\Models\BookView;
use App\Models\Buku;
use App\Models\TransaksiNonPelajar;
use App\Models\TransaksiPelajar;
use App\Models\VisitorLog;
use Illuminate\Http\JsonResponse;

class LibraryStatsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => [
                'books' => Buku::count(),
                'available_stock' => Buku::where('status', 'tersedia')->sum('stok_tersedia'),
                'student_members' => AnggotaPelajar::count(),
                'public_members' => AnggotaNonPelajar::count(),
                'active_loans' => TransaksiPelajar::where('status', 'dipinjam')->count()
                    + TransaksiNonPelajar::where('status', 'dipinjam')->count(),
                'overdue_loans' => TransaksiPelajar::where('status', 'terlambat')->count()
                    + TransaksiNonPelajar::where('status', 'terlambat')->count(),
                'visits_today' => VisitorLog::whereDate('checkin_at', today())->count(),
                'book_views' => BookView::where('duration_seconds', '>=', 60)->count(),
            ],
        ]);
    }
}
