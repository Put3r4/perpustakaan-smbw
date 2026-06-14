@props(['title' => 'Dashboard'])

@include('layouts.dashboard', ['title' => $title, 'slot' => $slot])
