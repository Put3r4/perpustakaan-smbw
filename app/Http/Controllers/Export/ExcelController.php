<?php

namespace App\Http\Controllers\Export;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ExcelController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => 'Fitur export Excel akan disambungkan pada sprint laporan.',
        ]);
    }
}
