<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->orderBy('id', 'desc')
            ->where('published', '=', 1)
            ->paginate(8);

        return view('product.index', [
           'products' => $products,
        ]);
    }

    public function view(Product $product): View
    {
        return  view('product.view', [
            'product' => $product,
        ]);
    }
}
