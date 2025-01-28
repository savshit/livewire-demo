<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Livewire::component('create-invoice', \App\Http\Livewire\CreateInvoice::class);
    }

    public function register()
    {
        //
    }
}
