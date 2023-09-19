<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->query('category');
        if ($params) {
            $param = explode(',', $params);

            $products = Product::with('category')->where('category_id', $param)->latest()->paginate(
                5
            );
            return ProductResource::collection($products);
        } else {

            $products = Product::with('category')->latest()->paginate(5);
            return ProductResource::collection($products);
        }

    }

    public function show($id)
    {
        $products = Product::where('id', $id)->first();
        return new ProductResource($products);
    }
}
