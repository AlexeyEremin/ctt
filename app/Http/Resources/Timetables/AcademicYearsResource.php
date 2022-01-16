<?php

namespace App\Http\Resources\Timetables;

use Illuminate\Http\Resources\Json\JsonResource;

class AcademicYearsResource extends JsonResource
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
            ['name' => $this->year->name];
    }
}
