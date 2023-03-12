<?php

namespace App\Http\Controllers;

use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use App\Traits\StorageImageTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class AdminSliderController extends Controller
{
    use StorageImageTrait;

    private $slider;

    public function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index()
    {
        $sliders = $this->slider->latest()->paginate(8);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function store(SliderRequest $request)
    {
        try {
            DB::beginTransaction();
            $slider = $this->slider->where('image_name', $request->image_path->getClientOriginalName())->first();
            if (empty($slider)) {
                $dataUploadImage = $this->storageUploadImage($request->image_path, 'sliders');
                $this->slider->create([
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
            $this->slider->find($id)->delete();
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
        $slider = $this->slider->find($id);
        $sliders = $this->slider->latest()->paginate(8);
        return view('admin.sliders.edit', compact('slider', 'sliders'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $slider = $this->slider->find($id);
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
