<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Categories\CategoriesService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    private CategoriesService $categoriesService;

    public function __construct(CategoriesService $cService)
    {
        $this->categoriesService = $cService;
    }

    public function index()
    {
        $categories = $this->categoriesService->getPaginatedCategories();

        return view('admin/categories/index', compact('categories'));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $categories = $this->categoriesService->getAllCategories();

        return view('admin/categories/create', compact('categories'));
    }

    public function store(CreateCategoryRequest $request)
    {
        $this->categoriesService->createNewCategory($request->validated());

        return redirect()->route('admin.categories.index');
    }

    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();

        return view('admin/categories/edit', compact('category', 'categories'));
    }

    public function update(UpdateCategoryRequest $request, Category $category )
    {
        $this->categoriesService->updateCategory($category->id, $request->validated());

        return redirect()->route('admin.categories.edit', $category);
    }

    public function destroy(Category $category)
    {
        $this->middleware('permission:' . config('permission.access.categories.delete'));

        $this->categoriesService->destroy($category);

        return redirect()->route('admin.categories.index');
    }
}
