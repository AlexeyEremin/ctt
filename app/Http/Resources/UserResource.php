<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $role = '';
        switch($this->role) {
            case 'timetable': $role = 'Управление УК'; break;
            case 'creator': $role = 'Полные права'; break;
            default: $role = 'Нет доступа';
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'login' => $this->login,
            'organization' => $this->organization,
            'campus' => $this->campus,
            'access' => $this->role,
            'role' => $role
        ];
    }
}
