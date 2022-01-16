<?php

namespace App\Http\Resources\Timetables\Schedule;

use Illuminate\Http\Resources\Json\JsonResource;

class HorlyLoadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request) + [
            'lesson_types' => $this->lessonType
            ];
    }
}
