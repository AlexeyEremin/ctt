<?php

namespace App\Http\Resources;

use App\Models\Discipline;
use App\Models\Teacher;
use Illuminate\Http\Resources\Json\JsonResource;

class JoinTeacherDisciplineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request) +
            [
                'teacher' => $this->teacher,
                'discipline' => $this->discipline
            ];
    }
}
