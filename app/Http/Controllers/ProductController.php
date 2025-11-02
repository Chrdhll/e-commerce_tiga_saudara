<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Logika ini meniru ProductsPage.tsx
    public function index(Request $request)
    {
        $productsQuery = Product::query();
        $categories = Category::all();

        // Filter by search
        if ($request->filled('search')) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category') && $request->category != 'all') {
            $productsQuery->where('category_id', $request->category);
        }

        // Sort products
        if ($request->filled('sort')) {
            if ($request->sort == 'price-asc') {
                $productsQuery->orderBy('price', 'asc');
            } elseif ($request->sort == 'price-desc') {
                $productsQuery->orderBy('price', 'desc');
            } elseif ($request->sort == 'name') {
                $productsQuery->orderBy('name', 'asc');
            }
        }

        $products = $productsQuery->get();
        
        return view('pages.products', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
       
        $product->load('category');

        // Ambil produk terkait (misal: 4 produk lain dari kategori yang sama)
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id) // Jangan tampilkan produk ini sendiri
                                ->with('category')
                                ->take(4)
                                ->get();

        return view('pages.product-detail', compact('product', 'relatedProducts'));
    }
}