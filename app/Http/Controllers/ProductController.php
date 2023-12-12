<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::orderBy('id', 'desc')->paginate(5);

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
