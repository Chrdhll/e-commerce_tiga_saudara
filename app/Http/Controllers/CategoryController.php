<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    // Logika ini meniru CategoriesPage.tsx
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        $products = Product::all(); // Untuk fallback jika diperlukan
        
        return view('pages.categories', compact('categories', 'products'));
    }
}