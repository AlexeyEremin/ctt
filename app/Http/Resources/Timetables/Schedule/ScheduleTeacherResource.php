<?php

namespace App\Http\Resources\Timetables\Schedule;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'group_disciplines' => $this->throwGroupDisciplines()->pluck('group_disciplines.id')
        ];
    }
}
