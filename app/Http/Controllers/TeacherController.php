<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherCreateValidation;
use App\Http\Resources\TeacherDisciplinesResource;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show()
    {
        $teachers = TeacherResource::collection(Auth::user()->teachers);
        return response($teachers);
    }

    public function create(TeacherCreateValidation $request)
    {
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->color = "ffffff";
        $teacher->organization_id = Auth::user()->organization_id;
        $teacher->save();
        return response([], 201);
    }

    public function createList(TeacherCreateValidation $request)
    {
        $teachers = explode(';', $request->name);
        foreach($teachers as $name) {
            $teacher = new Teacher();
            $teacher->name = $name;
            $teacher->color = "ffffff";
            $teacher->organization_id = Auth::user()->organization_id;
            $teacher->save();
        }
        return response([], 201);
    }

    public function edit(TeacherCreateValidation $request, Teacher $teacher)
    {
        $teacher->name = $request->name;
        $teacher->save();
        return response([], 202);
    }

    public function destroy(Teacher $teacher)
    {
        return response(TeacherDisciplinesResource::collection($teacher->teacherDisciplines()));
    }

    public function destroyDelete(Teacher $teacher)
    {
        if($teacher->teacherDisciplines()->count() > 0)
            return response([], 400);

        $teacher->delete();
        return response([], 202);
    }
}
