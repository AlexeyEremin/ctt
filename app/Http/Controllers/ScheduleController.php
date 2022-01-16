<?php

namespace App\Http\Controllers;

use App\Http\Resources\Timetables\Schedule\ScheduleTeacherResource;
use App\Http\Resources\Timetables\ScheduleResource;
use App\Http\Resources\Timetables\TeachersResource;
use App\Models\CouplesDate;
use App\Models\Group;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function groupDisciplines(Group $group)
    {
        return response(TeachersResource::collection($group->groupDisciplines));
    }

    public function open(CouplesDate $couplesDate, Group $group, Request $request)
    {
        $allIdDisciplines = $group->groupDisciplines()->pluck('id');
        $pair_0 = $couplesDate->schedules()->whereIn('group_discipline_id', $allIdDisciplines)->where('number', $request->number)->where('pair_type', 0)->first();
        $pair_1 = $couplesDate->schedules()->whereIn('group_discipline_id', $allIdDisciplines)->where('number', $request->number)->where('pair_type', 1)->first();
        $pair_2 = $couplesDate->schedules()->whereIn('group_discipline_id', $allIdDisciplines)->where('number', $request->number)->where('pair_type', 2)->first();
        $data = [
            0 => ($pair_0 ? ScheduleResource::make($pair_0): null),
            1 => ($pair_1 ? ScheduleResource::make($pair_1): null),
            2 => ($pair_2 ? ScheduleResource::make($pair_2): null),
        ];

        return response($data);
    }

    public function createAndDestroy(Request $request)
    {
        foreach($request->whole as $item) {
            $validate = Validator::make($item, [
                'group_discipline_id' => 'required',
                'horly_load_id' => 'required'
            ]);

            if($validate->fails()) {
                if($item['id'])
                    Schedule::destroy([$item['id']]);
                continue;
            }
            $data = [
                'group_discipline_id' => $item['group_discipline_id']['id'],
                'horly_load_id' => $item['horly_load_id'],
                'couples_date_id' => $request->couples_date_id,
                'cabinet' => ($item['cabinet'] ? $item['cabinet'] : '-'),
                'pair_type' => $item['pair_type'],
                'number' => $item['number'],
            ];
            Schedule::updateOrCreate(['id' => $item['id']], $data);
        }


        # Удаляем записи если существовали при условии изменения Данных
        if($request->subPair) {
            if($request->whole[0]['id'])
                Schedule::destroy([$request->whole[0]['id']]);
        }
        else {
            if($request->whole[1]['id'])
                Schedule::destroy([$request->whole[1]['id']]);
            if($request->whole[2]['id'])
                Schedule::destroy([$request->whole[2]['id']]);
        }

        return response([], 201);
    }

    public function schedule(CouplesDate $couplesDate)
    {
        $data = [
            'couplesDate' => CouplesDate::with([
                'academicYear.groups.GroupDisciplines.hourlyLoad.lessonType',
                'academicYear.groups.GroupDisciplines.teacherDiscipline.teacher',
                'academicYear.groups.GroupDisciplines.teacherDiscipline.discipline'])->find($couplesDate->id),
            'schedules' => $couplesDate->schedules()->orderBy('number', 'ASC')->get()
        ];
        return $data;
    }

    public function scheduleTeacher(CouplesDate $couplesDate)
    {
        $teacher_ids = Schedule::select('teacher_id')
            ->join('group_disciplines', 'group_disciplines.id', '=', 'schedules.group_discipline_id')
            ->join('teacher_disciplines', 'teacher_disciplines.id', '=', 'group_disciplines.teacher_discipline_id')
            ->distinct()
            ->where('couples_date_id', $couplesDate->id)
            ->pluck('teacher_id');

        $data = [
            'teachers' => ScheduleTeacherResource::collection(Teacher::whereIn('id', $teacher_ids)->get()),
            'couplesDate' => CouplesDate::with([
                'schedules.groupDiscipline.group',
                'schedules.horlyLoad.lessonType'])->find($couplesDate->id)
        ];
        return $data;
    }
}
