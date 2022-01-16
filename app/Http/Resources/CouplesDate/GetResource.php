<?php

namespace App\Http\Resources\CouplesDate;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        switch(Carbon::make($this->date)->dayOfWeek) {
            case 0: $week = 'Воскресенье'; break;
            case 1: $week = 'Понедельник'; break;
            case 2: $week = 'Вторник'; break;
            case 3: $week = 'Среда'; break;
            case 4: $week = 'Четверг'; break;
            case 5: $week = 'Пятница'; break;
            case 6: $week = 'Суббота'; break;
        }
        return [
            'id' => $this->id,
            'date' => Carbon::make($this->date)->format('d-m-Y'),
            'week' => $week
        ];
    }
}
