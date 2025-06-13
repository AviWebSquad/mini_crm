<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SalesOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = SalesOrder::sum('total');
        $totalOrders = SalesOrder::count();
        $lowStock = Product::where('quantity', '<', 10)->get();
        return view('dashboard', compact('totalSales', 'totalOrders', 'lowStock'));
    }
}
