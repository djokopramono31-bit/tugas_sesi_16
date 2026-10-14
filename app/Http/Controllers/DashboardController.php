<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProduk' => Product::count(),
            'totalKategori' => ProductCategory::count(),
        ]);
    }
}