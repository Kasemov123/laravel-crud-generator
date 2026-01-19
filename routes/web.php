<?php

use App\Livewire\CodeGenerator;
use App\Livewire\Components;
use App\Livewire\Home;
use App\Livewire\About;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/generator', CodeGenerator::class)
    ->middleware('throttle:5,1')
    ->name('generator');
Route::get('/components', Components::class)->name('components');
Route::get('/about', About::class)->name('about');
