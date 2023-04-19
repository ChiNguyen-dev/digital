<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use App\Helpers\CategoryRecursive;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\Interfaces\ICategoryService;

class AdminCategoryController extends Controller
{
    private CategoryRecursive $categoryRecursive;
    private ICategoryService $categoryService;
    private $categoriesShared;

    public function __construct(CategoryRecursive $categoryRecursive, ICategoryService $categoryService)
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->categoryService = $categoryService;
        $this->categoriesShared = app('shared')->get('categories');
    }

    public function index()
    {
        $categories = $this->categoryService->pagination($this->categoriesShared, 15);
        $htmlOption = $this->categoryRecursive->categoryRecursive();
        return view('admin.categories.index', compact('htmlOption', 'categories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryService->create([
            'cate_name' => $request->cate_name,
            'parent_id' => $request->parent_id,
            'slug' => Str::of($request->cate_name)->slug('-')
        ]);
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $categoriesSharing = $this->categoriesShared;
        $categories = $this->categoryService->pagination($categoriesSharing, 15);
        $category = $categoriesSharing->find($id);
        $htmlOption = $this->categoryRecursive->categoryRecursive($category->parent_id);
        return view('admin.categories.edit', compact('htmlOption', 'categories', 'category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->categoryService->update($id, [
            'cate_name' => $request->cate_name,
            'parent_id' => $request->parent_id,
            'slug' => Str::of($request->cate_name)->slug('-')
        ]);
        return redirect()->route('categories.index');
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->categoryService->delete($request->id);
            return response()->json([
                'message' => 'Deleted successfully'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Deleted failed'
            ], 500);
        }
    }
}
