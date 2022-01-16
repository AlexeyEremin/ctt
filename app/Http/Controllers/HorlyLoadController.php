<?php

namespace App\Http\Controllers;

use App\Http\Resources\GroupTeacherDisciplinesResource;
use App\Http\Resources\HourlyLoadResource;
use App\Models\Group;
use App\Models\GroupDiscipline;
use App\Models\HorlyLoad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorlyLoadController extends Controller
{
    public function show(Group $group)
    {
        return response(GroupTeacherDisciplinesResource::make($group));
    }

    public function showTeacher(GroupDiscipline $groupDiscipline)
    {
        $data['attached'] = HourlyLoadResource::collection($groupDiscipline->hourlyLoad);
        $data['notAttached'] = Auth::user()->lessonTypes;

        return response($data);
    }

    public function create(Request $request)
    {
        $hourlyLoad = new HorlyLoad();
        $hourlyLoad->lesson_type_id = $request->lesson_type_id;
        $hourlyLoad->group_discipline_id = $request->group_discipline_id;
        $hourlyLoad->amount = 0;
        $hourlyLoad->semester = 0;
        $hourlyLoad->save();

        return response([], 201);
    }

    public function update(HorlyLoad $horlyLoad, Request $request)
    {
        $horlyLoad->amount = $request->amount;
        $horlyLoad->semester = $request->semester;
        $horlyLoad->save();

        return response([], 202);
    }
}
