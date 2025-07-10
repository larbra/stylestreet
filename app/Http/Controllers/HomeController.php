<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = \App\Models\Tovar::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('latestProducts'));
    }
}
