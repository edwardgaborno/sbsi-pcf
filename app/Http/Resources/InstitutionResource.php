<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionResource extends JsonResource
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
            'text' => $this->institution, //as TEXT since select2 tag can only accept text key name
            'address' => $this->address,
            'contact_person' => $this->contact_person,
            'designation' => $this->designation,
            'thru_contact_person' => $this->thru_contact_person,
            'thru_designation' => $this->thru_designation,
        ];
    }
}
