<?php

namespace App\Http\Controllers;

use App\Enums\FruitUnit;
use App\Http\Requests\FruitStoreRequest;
use App\Models\Category;
use App\Models\Fruit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FruitController extends Controller
{
    public function index(Request $request): Response
    {
        $items = Fruit::latest()->with('category')->paginate();
        return Inertia::render('Fruit/Index', compact('items'));
    }

    public function create(): Response
    {
        $categories = Category::all();
        $units = FruitUnit::cases();
        return Inertia::render('Fruit/Create', compact('categories', 'units'));
    }

    public function store(FruitStoreRequest $request)
    {
        Fruit::create($request->validated());

        return redirect()->route('fruits.index');
    }
}
