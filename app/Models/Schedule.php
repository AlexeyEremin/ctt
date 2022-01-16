<?php

namespace App\Models;

use App\Http\Resources\Timetables\AnalyticsResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ["group_discipline_id","horly_load_id","couples_date_id", "cabinet","pair_type","number"];

    public function groupDiscipline()
    {
        return $this->belongsTo(GroupDiscipline::class);
    }

    public function couplesDate()
    {
       return $this->belongsTo(CouplesDate::class);
    }

    public function horlyLoad()
    {
        return $this->belongsTo(HorlyLoad::class);
    }

    public function analytics()
    {
        # Проверяем является ли тип пары проверочным через значение Consider
        if(!$this->horlyLoad->lessonType->consider)
            return false;

        # Вычисляем идентификатор преподавателя
        $groupDiscipline = $this->groupDiscipline;
        $teacher_id = $groupDiscipline->teacherDiscipline;

        # Получаем дисциплины которые ведет преподаватель Массив Идентификаторов
        $teacher_ids = TeacherDiscipline::whereIn('teacher_id', $teacher_id)->pluck('id');
        # Получаем группы с дисциплинами которыми подвязан преподаватель
        $groupDiscipline_ids = GroupDiscipline::whereIn('teacher_discipline_id', $teacher_ids)->pluck('id');
        # Получаем идентификаторы Часов которые должен выдать педагог, при условии, что Тип урока в расписании
        $horlyLoad_ids = HorlyLoad::select('horly_loads.id as id')
            ->join('lesson_types', 'lesson_type_id', '=', 'lesson_types.id')
            ->whereIn('group_discipline_id', $groupDiscipline_ids)
            ->where('consider', true)
            ->pluck('id');

        # Получаем дату и получаем идентификаторы совпадающие с другими днями
        $couplesDate_date = $this->couplesDate->date;
        $couplesDate_ids = CouplesDate::where('date', $couplesDate_date)->pluck('id');
        # Получаем количество элементов
        $schedules = self::whereIn('horly_load_id', $horlyLoad_ids)
            ->whereIn('couples_date_id', $couplesDate_ids)
            ->where('number', $this->number)
            ->where('id', '<>', $this->id)
            ->get();
        return (count($schedules) ? AnalyticsResource::collection($schedules) : false);
    }
}
