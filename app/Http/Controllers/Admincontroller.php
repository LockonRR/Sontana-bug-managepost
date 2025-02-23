<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class Admincontroller extends Controller
{
    public function admindashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function manageposts()
    {
        return Inertia::render('Admin/Manageposts');
    }

    public function reports()
    {
        return Inertia::render('Admin/Reports');
    }

    public function usermanage()
    {

        return Inertia::render('Admin/Usermanage');
    }
}
