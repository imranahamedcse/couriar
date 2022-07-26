<?php

namespace App\Http\Resources\v10;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"                => $this->id,
            "name"              => $this->name,
            "email"             => $this->email,
            "phone"             => $this->mobile,
            "user_type"         => $this->user_type,
            "hub_id"            => $this->hub_id,
            "hub"               => $this->hub,
            "merchant"          => $this->merchant,
            "joining_date"      => $this->joining_date,
            "address"           => $this->address,
            "salary"            => $this->salary,
            "status"            => $this->status,
            "statusName"        => trans("status." . $this->status),
            "image"             => $this->image,
            'created_at'        => $this->created_at->format('d M Y, h:i A'),
            'updated_at'        => $this->updated_at->format('d M Y, h:i A'),
        ];
    }

}
