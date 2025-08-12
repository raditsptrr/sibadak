<?php
// File: app/Http/Controllers/Admin/SubCategoryController.php (Perbaikan)

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\MainCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index()
    {
        // FIX: Mengganti latest() dengan orderBy('name')
        $subCategories = SubCategory::with('mainCategory')->orderBy('name')->paginate(10);
        return view('admin.sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        $mainCategories = MainCategory::orderBy('name')->get();
        return view('admin.sub_categories.create', compact('mainCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'name' => 'required|string|max:255',
        ]);
        SubCategory::create($request->all());
        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub Kategori berhasil ditambahkan.');
    }

    public function edit(SubCategory $subCategory)
    {
        $mainCategories = MainCategory::orderBy('name')->get();
        return view('admin.sub_categories.edit', compact('subCategory', 'mainCategories'));
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'main_category_id' => 'required|exists:main_categories,id',
            'name' => 'required|string|max:255',
        ]);
        $subCategory->update($request->all());
        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub Kategori berhasil diperbarui.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();
        return redirect()->route('admin.sub-categories.index')->with('success', 'Sub Kategori berhasil dihapus.');
    }
}