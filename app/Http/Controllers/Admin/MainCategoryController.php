<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class MainCategoryController extends Controller
{
    public function index()
    {
        // FIX: Mengganti latest() dengan orderBy('name') karena tidak ada timestamps
        $mainCategories = MainCategory::orderBy('name')->paginate(10);
        return view('admin.main_categories.index', compact('mainCategories'));
    }

    public function create()
    {
        return view('admin.main_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:main_categories,name|max:255']);
        MainCategory::create($request->all());
        return redirect()->route('admin.main-categories.index')->with('success', 'Kategori Utama berhasil ditambahkan.');
    }

    public function edit(MainCategory $mainCategory)
    {
        return view('admin.main_categories.edit', compact('mainCategory'));
    }

    public function update(Request $request, MainCategory $mainCategory)
    {
        $request->validate(['name' => 'required|string|unique:main_categories,name,' . $mainCategory->id . '|max:255']);
        $mainCategory->update($request->all());
        return redirect()->route('admin.main-categories.index')->with('success', 'Kategori Utama berhasil diperbarui.');
    }

    public function destroy(MainCategory $mainCategory)
    {
        $mainCategory->delete();
        return redirect()->route('admin.main-categories.index')->with('success', 'Kategori Utama berhasil dihapus.');
    }
}