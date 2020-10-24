<?php

namespace App\Http\Controllers\Site;

use Cart;
use Illuminate\Http\Request;
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
}
