<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => strtoupper($this->title),
            'start' => $this->start,
            'end' => $this->end,
            'color' => $this->color,
            'user_id'=> $this->user_id,
        ];
    }
}
