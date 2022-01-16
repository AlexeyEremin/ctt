<?php

namespace App\Http\Resources\Timetables;

use Illuminate\Http\Resources\Json\JsonResource;

class AnalyticsResource extends JsonResource
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
            'campus' => $this->groupDiscipline->group->academicYear->campus->name,
            'group' => $this->groupDiscipline->group->name
        ];
    }
}
