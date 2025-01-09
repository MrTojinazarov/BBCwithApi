<?php
namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $all = Category::orderBy('id', 'desc')->paginate(10);

        return response()->json(['all' => $all, 'message' => 'Sizda hozircha hech narsa yoq']);
    }

    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->is_active = $request->is_active ?? 0;
        $category->save();

        return response()->json([
            'message' => 'Category created successfully.',
            'category' => $category
        ], 201);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request->name;
        $category->is_active = $request->is_active ?? 0;
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully.',
            'category' => $category
        ]);
    }

    public function delete(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully.'
        ]);
    }
}
