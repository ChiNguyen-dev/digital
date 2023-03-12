<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use App\Models\Color;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminColorController extends Controller
{
    private $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    public function index()
    {
        $colors = $this->color->latest()->paginate(15);
        return view('admin.colors.index', compact('colors'));
    }

    public function store(ColorRequest $request): RedirectResponse
    {
        $this->color->firstOrCreate([
            'name' => $request->name,
            'style' => $request->style
        ]);
        return redirect()->route('color.index');
    }

    public function edit($id)
    {
        $colors = $this->color->paginate(8);
        $color = $this->color->find($id);
        return view('admin.colors.edit', compact('colors', 'color'));
    }

    public function update(ColorRequest $request, $id)
    {
        $color = $this->color->find($id);
        $color->update(['name' => $request->name, 'style' => $request->style]);
        return redirect()->route('color.index');
    }

    public function delete(Request $request): JsonResponse
    {
        try {
            $this->color->find($request->id)->delete();
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
