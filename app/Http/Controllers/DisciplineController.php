<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherCreateValidation;
use App\Http\Resources\DisciplineTeacherResource;
use App\Http\Resources\JoinTeacherDisciplineResource;
use App\Http\Resources\TeacherResource;
use App\Models\Discipline;
use App\Models\TeacherDiscipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisciplineController extends Controller
{
    public function show()
    {
        $data = TeacherResource::collection(Auth::user()->disciplines);
        return response($data);
    }

    public function create(TeacherCreateValidation $request)
    {
        $item = new Discipline();
        $item->name = $request->name;
        $item->organization_id = Auth::user()->organization_id;
        $item->save();
        return response([], 201);
    }

    public function createList(TeacherCreateValidation $request)
    {
        $disciplines = explode(';', $request->name);
        foreach($disciplines as $name) {
            $discipline = new Discipline();
            $discipline->name = $name;
            $discipline->organization_id = Auth::user()->organization_id;
            $discipline->save();
        }
        return response([], 201);
    }

    public function edit(TeacherCreateValidation $request, Discipline $discipline)
    {
        $discipline->name = $request->name;
        $discipline->save();
        return response([], 202);
    }

    public function destroy(Discipline $discipline)
    {
        return response(DisciplineTeacherResource::collection($discipline->teacherDisciplines()));
    }

    public function destroyDelete(Discipline $discipline)
    {
        if($discipline->teacherDisciplines()->count() > 0)
            return response([], 400);

        $discipline->delete();
        return response([], 202);
    }


    public function teacherDiscipline(Discipline $discipline)
    {
        $data['attached'] = JoinTeacherDisciplineResource::collection($discipline->teacherDisciplines);
        $data['notAttached'] = Auth::user()->teachers()->whereNotIn('id', $data['attached']->pluck('teacher_id'))->get();

        return response($data);
    }

    public function teacherDisciplineCreate(Discipline $discipline, Request $request)
    {
        TeacherDiscipline::firstOrCreate(['teacher_id' => $request->id, 'discipline_id' => $discipline->id]);

        return response([], 201);
    }

    public function teacherDisciplineDestroy(Discipline $discipline, Request $request)
    {
        TeacherDiscipline::destroy($request->id);
        return response([], 202);
    }
}
