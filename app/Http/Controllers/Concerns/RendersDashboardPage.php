<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Contracts\View\View;

trait RendersDashboardPage
{
    protected function dashboardPage(string $title, string $description): View
    {
        return view('dashboard.placeholder', [
            'title' => $title,
            'description' => $description,
        ]);
    }
}
