<?php

namespace App\Http\Resources;

use App\Models\Discipline;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherDisciplinesResource extends JsonResource
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
            'discipline' => $this->belongsTo(Discipline::class)->first()->name
        ];
    }
}
