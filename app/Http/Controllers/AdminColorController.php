<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Repositories\Interfaces\IColorRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminColorController extends Controller
{
    private $colorRepo;

    public function __construct(IColorRepository $iColorRepository)
    {
        $this->colorRepo = $iColorRepository;
    }

    public function index()
    {
        $colors = $this->colorRepo->getAllPaginateLatest(15);
        return view('admin.colors.index', compact('colors'));
    }

    public function store(ColorRequest $request): RedirectResponse
    {
        $this->colorRepo->create([
            'name' => $request->name,
            'style' => $request->style,
        ]);
        return redirect()->route('color.index');
    }

    public function edit($id)
    {
        $colors = $this->colorRepo->getAllPaginateLatest(15);
        $color = $colors->find($id);
        return view('admin.colors.edit', compact('colors', 'color'));
    }

    public function update(ColorRequest $request, $id)
    {
        $this->colorRepo->update($id, ['name' => $request->name, 'style' => $request->style]);
        return redirect()->route('color.index');
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->colorRepo->delete($request->id);
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
