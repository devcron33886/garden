<?php

namespace App\Http\Controllers;

use App\FileManager;
use App\Http\Requests\ValidateHomeSlide;
use App\HomeSlide;
use Illuminate\Support\Facades\Storage;

class HomeSlideController extends Controller
{
    public function index()
    {
        $slides = HomeSlide::all();
        return view('admins.home_slides', compact('slides'));
    }

    public function store(ValidateHomeSlide $request)
    {
        $request->validated();

        $id = $request->input('id');
        if ($id > 0) {
            $model = HomeSlide::query()->find($id);
        } else {
            $model = new HomeSlide();
        }

        $model->header = $request->input('header');
        $model->description = $request->input('description');
        $model->is_active = $request->input('is_active') === 'on';
        $model->show_text = $request->input('show_text') === 'on';

        if ($request->hasFile('image')) {
            $PATH = FileManager::PUBLIC_SLIDES;
            Storage::delete($PATH . $model->image);

            $file = $request->file('image');
            $path = $file->store($PATH);
            $image = str_replace($PATH, '', $path);
            $model->image = $image;
        }

        $model->save();
        session()->flash('success', 'Slide successfully saved');
        return back();
    }

    public function show(HomeSlide $slide)
    {
        return $slide;
    }

    public function destroy(HomeSlide $slide)
    {
        try {

            $slide->delete();

            $PATH = FileManager::PUBLIC_SLIDES;
            Storage::delete($PATH . $slide->image);

        } catch (Exception $e) {
            return \response()->json('Unable to delete product', 400);
        }
        session()->flash('success', 'Slide successfully deleted');
        return back();
    }
}
