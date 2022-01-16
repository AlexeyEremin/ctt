<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherCreateValidation;
use App\Http\Resources\TeacherResource;
use App\Models\AcademicYear;
use App\Models\Campus;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function show(AcademicYear $academicYear)
    {
        $data = TeacherResource::collection($academicYear->groups);
        return response($data);
    }

    public function create(TeacherCreateValidation $request)
    {
        $item = new Group();
        $item->name = $request->name;
        $item->academic_year_id = $request->academic_year_id;
        $item->save();
        return response([], 201);
    }

    public function createList(TeacherCreateValidation $request)
    {
        $groups = explode(';', $request->name);
        foreach($groups as $name) {
            $item = new Group();
            $item->name = $name;
            $item->academic_year_id = $request->academic_year_id;
            $item->save();
        }
        return response([], 201);
    }

    public function edit(TeacherCreateValidation $request, Group $group)
    {
        $group->name = $request->name;
        $group->save();
        return response([], 202);
    }

    public function destroy(Group $group)
    {
        return response(['count' => $group->groupDisciplines()->count()]);
    }

    public function destroyDelete(Group $group)
    {
        if($group->groupDisciplines()->count() > 0)
            return response([], 400);

        $group->delete();
        return response([], 202);
    }
}
