<?php

namespace App\Http\Controllers\Cockpit;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class WorkbenchController extends Controller
{
    public function projects(): View
    {
        return view('pages.projects');
    }

    public function databases(): View
    {
        return view('pages.databases');
    }

    public function tinker(): View
    {
        return view('pages.tinker');
    }

    public function servers(): View
    {
        return view('pages.servers');
    }

    public function runtimes(): View
    {
        return view('pages.runtimes');
    }

    public function notes(): View
    {
        return view('pages.notes');
    }

    public function commands(): View
    {
        return view('pages.commands');
    }

    public function auditLog(): View
    {
        return view('pages.audit-log');
    }
}
