<?php

namespace App\Http\Controllers\Site;

use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Contracts\ProductContract;
use App\Http\Controllers\BaseController;
use App\Contracts\AttributeContract;

class ProductController extends BaseController
{
    protected $productRepository;

    protected $attributeRepository;

    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
        $attributeRepository = $this->attributeRepository;
    }

    public function productList()
    {
        $products = $this->productRepository->listProducts();

        return view('site.pages.homepage', compact('products'));
    }

    public function show($slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);

        $attributes = null;

        if($this->attributeRepository != null){
            $attributes = $this->attributeRepository->listAttributes();
        }
        return view('site.pages.product', compact('product', 'attributes'));
    }

    public function addToCart(Request $request)
    {
        $product = $this->productRepository->findProductById($request->input('productId'));
        $options = $request->except('_token', 'productId', 'price', 'qty');

        Cart::add(uniqid(), $product->name, $request->input('price'), $request->input('qty'), $options);

        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }

    public function filterProduct()
    {
        // $sql = 'SELECT \* FROM products WHERE name LIKE %' . '';
        $sanitizedVariable = filter_var($_GET['product_query'], FILTER_SANITIZE_STRING);
        
        if($sanitizedVariable != false){
            $sql = "SELECT * FROM products WHERE name LIKE '%" . $sanitizedVariable . "%'";
            $products = DB::select($sql);

            return view('site.pages.homepage', compact('products'));
        } else {
            return redirect()->back()->with('message', 'Something went wrong with your query');
        }

    }
}
