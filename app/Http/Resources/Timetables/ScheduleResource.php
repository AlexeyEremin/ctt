<?php

namespace App\Http\Resources\Timetables;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'id' => $this->id,
            'group_discipline_id' => TeachersResource::make($this->groupDiscipline),
            'horly_load_id' => $this->horly_load_id,
            'cabinet' => $this->cabinet,
            'pair_type' => $this->pair_type,
            'number' => $this->number,
            'analytics' => $this->analytics()
        ];
    }
}
