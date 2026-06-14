@props(['title' => config('app.name', 'Perpustakaan Kota Sumbawa')])

@include('layouts.app', ['title' => $title, 'slot' => $slot])
