<?php

namespace App\Http\Resources\Timetables;

use Illuminate\Http\Resources\Json\JsonResource;

class TeachersResource extends JsonResource
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
            'name' => $this->teacherDiscipline->teacher->name . ' / ' . $this->teacherDiscipline->discipline->name,
            'horly' => HorlyResource::collection($this->hourlyLoad)
        ];
    }
}
