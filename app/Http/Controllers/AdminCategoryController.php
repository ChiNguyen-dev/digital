<?php

namespace App\Http\Controllers;

use App\Helpers\CategoryRecursive;
use App\Http\Requests\StoreCategoryRequest;
use App\Repositories\Interfaces\ICategoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    private $categoryRecursive;
    private $categoryRepo;
    private $categoriesShared;

    public function __construct(CategoryRecursive $categoryRecursive, ICategoryRepository $categoryRepo)
    {
        $this->categoryRecursive = $categoryRecursive;
        $this->categoryRepo = $categoryRepo;
        $this->categoriesShared = app('shared')->get('categories');
    }

    public function index()
    {
        $categories = $this->categoryRepo->pagination($this->categoriesShared, 15);
        $htmlOption = $this->categoryRecursive->categoryRecursive();
        return view('admin.categories.index', compact('htmlOption', 'categories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryRepo->create([
            'cate_name' => $request->cate_name,
            'parent_id' => $request->parent_id,
            'slug' => Str::of($request->cate_name)->slug('-')
        ]);
        return redirect()->route('categories.index');
    }

    public function edit($id)
    {
        $categories = $this->categoryRepo->pagination($this->categoriesShared, 15);
        $category = $categories->find($id);
        $htmlOption = $this->categoryRecursive->categoryRecursive($category->parent_id);
        return view('admin.categories.edit', compact('htmlOption', 'categories', 'category'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->categoryRepo->update($id, [
            'cate_name' => $request->cate_name,
            'parent_id' => $request->parent_id,
            'slug' => Str::of($request->cate_name)->slug('-')
        ]);
        return redirect()->route('categories.index');
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->categoryRepo->delete($request->id);
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
