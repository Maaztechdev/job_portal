<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('jobs')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'icon' => 'nullable|string|max:255', // Assuming icon is a class name or SVG path
        ]);

        Category::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'icon' => 'nullable|string|max:255',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $category->delete();

        return back()->with('success', 'Category deleted successfully.');
    }
}
