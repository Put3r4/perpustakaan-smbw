<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PdfController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => 'Fitur export PDF akan disambungkan pada sprint laporan.',
        ]);
    }
}
