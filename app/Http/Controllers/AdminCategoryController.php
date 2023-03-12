<?php

namespace App\Http\Controllers;

use App\component\CategoryRecursive;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    private $category;
    private $categoryRecursive;

    public function __construct(Category $category, CategoryRecursive $categoryRecursive)
    {
        $this->category = $category;
        $this->categoryRecursive = $categoryRecursive;
    }

    public function index()
    {
        $categories = $this->category->latest()->paginate(15);
        $htmlOption = $this->categoryRecursive->categoryRecursive('');
        return view('admin.categories.index', compact('htmlOption', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->category->create([
            'cate_name' => $request->cate_name,
            'parent_id' => $request->parent_id,
            'slug' => Str::of($request->cate_name)->slug('-')
        ]);
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $categories = $this->category->latest()->paginate(15);
        $category = $this->category->find($id);
        $htmlOption = $this->categoryRecursive->categoryRecursive($category->parent_id);
        return view('admin.categories.edit', compact('htmlOption', 'categories', 'category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->category->find($id)->update([
            'cate_name' => $request->cate_name,
            'parent_id' => $request->parent_id,
            'slug' => Str::of($request->cate_name)->slug('-')
        ]);
        return redirect()->route('categories.index');
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->category->find($request->id)->delete();
            return response()->json([
                'code' => 200,
                'message' => 'Success'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'Failed'
            ], 500);
        }
    }
}
