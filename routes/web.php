<?php

use App\Livewire\Projects\Index;
use App\Livewire\Projects\Show;
use Illuminate\Support\Facades\Route;

Route::get('/', Index::class)->name('projects.index');
Route::get('/projects/{project}', Show::class)->name('projects.show');
