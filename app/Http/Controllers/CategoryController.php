<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin')->except(['index', 'show']);
            $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);

    }

    /**
     * عرض قائمة التصنيفات
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * عرض نموذج إنشاء تصنيف
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * حفظ التصنيف الجديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        Category::create($request->only('name'));

        return redirect()->route('categories.index')
            ->with('success', 'تم إنشاء التصنيف بنجاح');
    }

    /**
     * عرض تصنيف محدد
     */
    public function show(Category $category)
    {
        $tasks = $category->tasks()->paginate(10);
        return view('categories.show', compact('category', 'tasks'));
    }

    /**
     * عرض نموذج تعديل التصنيف
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * تحديث التصنيف
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category->update($request->only('name'));

        return redirect()->route('categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    /**
     * حذف التصنيف
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'تم حذف التصنيف بنجاح');
    }
}
