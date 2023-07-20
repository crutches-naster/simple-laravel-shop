<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\Products\ProductsService;
use Illuminate\Http\RedirectResponse;

class ProductsController extends Controller
{
    private ProductsService $productsService;

    public function __construct(ProductsService $pService)
    {
        $this->productsService = $pService;
    }
    public function index()
    {
        $products = $this->productsService->getAllProductsWithCategories();

        return view('admin/products/index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('admin/products/create', compact('categories'));
    }

    public function store(CreateProductRequest $request)
    {
        //dd($request);

        return $this->productsService->createNewProduct( $request->validated() )
            ? redirect()->route('admin.products.index')
            : redirect()->back()->withInput();
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $productCategories = $product->categories()->get()->pluck('id')->toArray();

        return view('admin/products/edit', compact('product', 'categories', 'productCategories'));
    }

    public function update(UpdateProductRequest $request, Product $product )
    {
        return $this->productsService->updateProduct($product, $request->validated()) ?
            redirect()->route('admin.products.edit', $product) :
            redirect()->back()->withInput();
    }

    public function destroy(Product $product) : RedirectResponse
    {
        $this->productsService->destroyProduct($product);

        return redirect()->route('admin.products.index');
    }
}
