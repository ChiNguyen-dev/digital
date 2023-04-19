<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ColorRequest;
use App\Http\Controllers\Controller;
use App\Services\Interfaces\IColorService;

class AdminColorController extends Controller
{
    private IColorService $colorService;

    public function __construct(IColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    public function index()
    {
        $colors = $this->colorService->getAllPaginateLatest(15);
        return view('admin.colors.index', compact('colors'));
    }

    public function store(ColorRequest $request): RedirectResponse
    {
        $this->colorService->create([
            'name' => $request->name,
            'style' => $request->style,
        ]);
        return redirect()->route('color.index');
    }

    public function edit($id)
    {
        $colors = $this->colorService->getAllPaginateLatest(15);
        $color = $colors->find($id);
        return view('admin.colors.edit', compact('colors', 'color'));
    }

    public function update(ColorRequest $request, $id)
    {
        $this->colorService->update($id, ['name' => $request->name, 'style' => $request->style]);
        return redirect()->route('color.index');
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->colorService->delete($request->id);
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
