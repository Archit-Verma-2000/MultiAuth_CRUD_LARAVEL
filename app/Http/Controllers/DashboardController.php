<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class DashboardController extends Controller
{
    Public function index(){
         // Fetch all products
         $products = Product::all();

         // Pass the products data to the view
         return view('dashboard', compact('products'));
    }
}