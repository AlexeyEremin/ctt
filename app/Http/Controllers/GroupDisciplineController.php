<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupDisciplineResource;
use App\Http\Resources\TeachersDisciplinesResource;
use App\Models\Group;
use App\Models\GroupDiscipline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupDisciplineController extends Controller
{
    public function show(Group $group)
    {
        $data['teachers'] = TeachersDisciplinesResource::collection(Auth::user()->teachers);
        return response($data);
    }

    public function createOrDestroy(Group $group, Request $request)
    {
        if($request->destroy) {
            $groupDiscipline = GroupDiscipline::find($request->destroy['id']);
            $groupDiscipline->delete();

            return response([], 202);
        }

        $groupDiscipline = new GroupDiscipline();
        $groupDiscipline->group_id = $group->id;
        $groupDiscipline->teacher_discipline_id = $request->id;
        $groupDiscipline->save();

        return response([], 201);
    }
}
