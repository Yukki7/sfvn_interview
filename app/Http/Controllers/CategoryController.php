<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(Request $request): Response
    {
        $categories = Category::latest()->paginate();
        return Inertia::render('Category/Index', compact('categories'));
    }

    public function create(): Response
    {
        return Inertia::render('Category/Create');
    }

    public function store(CategoryStoreRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index');
    }
}
