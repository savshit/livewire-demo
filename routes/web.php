<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ChangeEvent;
use App\Livewire\ClickEvent;
use App\Livewire\NotificationSweetAlert;
use App\Livewire\NotificationDemo;
use App\Livewire\Select2;
use App\Livewire\Posts;
use App\Livewire\Statecitydropdown;
use App\Livewire\InvoiceDashboard;

Route::get('/', InvoiceDashboard::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
