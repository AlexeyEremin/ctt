<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonTypeCreateValidation;
use App\Http\Requests\TeacherCreateValidation;
use App\Http\Resources\TeacherResource;
use App\Models\LessonType;
use Illuminate\Support\Facades\Auth;

class LessonTypeController extends Controller
{
    public function show()
    {
        $data = TeacherResource::collection(Auth::user()->lessonTypes);
        return response($data);
    }

    public function create(LessonTypeCreateValidation $request)
    {
        $item = new LessonType();
        $item->name = $request->name;
        $item->consider = $request->consider;
        $item->off_grid = $request->off_grid;
        $item->organization_id = Auth::user()->organization_id;
        $item->save();
        return response([], 201);
    }

    public function edit(TeacherCreateValidation $request, LessonType $lessonType)
    {
        $lessonType->name = $request->name;
        $lessonType->save();
        return response([], 202);
    }

    public function editCheckbox(LessonType $lessonType, $checkbox)
    {
        if($checkbox == 'consider')
            $lessonType->consider = !$lessonType->consider;
        if($checkbox == 'off_grid')
            $lessonType->off_grid = !$lessonType->off_grid;
        $lessonType->save();
        return response([], 202);
    }

    public function destroy(LessonType $lessonType)
    {
        return response(['count' => $lessonType->horlyLoad()->count()]);
    }

    public function destroyDelete(LessonType $lessonType)
    {
        if($lessonType->horlyLoad()->count() > 0)
            return response([], 400);

        $lessonType->delete();
        return response([], 202);
    }
}
