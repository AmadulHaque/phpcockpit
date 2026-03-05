<?php

use App\Http\Controllers\Cockpit\WorkbenchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WorkbenchController::class, 'tinker'])->name('home');

Route::controller(WorkbenchController::class)->group(function () {
    Route::get('/projects', 'projects')->name('cockpit.projects');
    Route::get('/databases', 'databases')->name('cockpit.databases');
    Route::get('/tinker', 'tinker')->name('cockpit.tinker');
    Route::get('/servers', 'servers')->name('cockpit.servers');
    Route::get('/runtimes', 'runtimes')->name('cockpit.runtimes');
    Route::get('/notes', 'notes')->name('cockpit.notes');
    Route::get('/commands', 'commands')->name('cockpit.commands');
    Route::get('/audit-log', 'auditLog')->name('cockpit.audit-log');
});
