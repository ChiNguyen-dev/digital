<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Traits\StorageImageTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Services\Interfaces\ISliderService;

class AdminSliderController extends Controller
{
    use StorageImageTrait;

    private ISliderService $sliderService;

    public function __construct(ISliderService $sliderService)
    {
        $this->sliderService = $sliderService;
        $this->middleware(function ($request, $next) {
            session([
                'active' => 'slider',
            ]);
            return $next($request);
        });
    }

    public function index()
    {
        $sliders = $this->sliderService->getAllPaginateLatest(15);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(SliderRequest $request)
    {
        try {
            DB::beginTransaction();
            $slider = $this->sliderService->getSliderByImageName($request->image_path->getClientOriginalName());
            if (empty($slider)) {
                $dataUploadImage = $this->storageUploadImage($request->image_path, 'sliders');
                $this->sliderService->create([
                    'name' => $request->name,
                    'image_name' => $dataUploadImage['file_name'],
                    'image_path' => $dataUploadImage['file_path'],
                ]);
            }
            DB::commit();
            return redirect()->route('sliders.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }

    public function delete($id): JsonResponse
    {
        try {
            $this->sliderService->delete($id);
            return response()->json([
                'code' => 200,
                'message' => 'delete success',
            ], 200);
        } catch (\Exception $exception) {
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'deleted fail'
            ], 500);
        }
    }

    public function edit($id)
    {
        $sliders = $this->sliderService->getAllPaginateLatest(15);
        $slider = $sliders->find($id);
        return view('admin.sliders.edit', compact('slider', 'sliders'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $slider = $this->sliderService->find($id);
            $dataUpdateSlider = ['name' => $request->name];
            if ($request->hasFile('image_path')) {
                if (File::exists(public_path($slider->image_path))) File::delete(public_path($slider->image_path));
                $dataUploadImage = $this->storageUploadImage($request->image_path, 'sliders');
                $dataUpdateSlider['image_name'] = $dataUploadImage['file_name'];
                $dataUpdateSlider['image_path'] = $dataUploadImage['file_path'];
            }
            $slider->update($dataUpdateSlider);
            DB::commit();
            return redirect()->route('sliders.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('message: ' . $exception->getMessage() . ' Line: ' . $exception->getLine());
        }
    }
}
