<?php

namespace App\Http\Resources;

use App\Http\Resources\PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'     => $this->id,
            'name'   => $this->name,
            'email'  => $this->email,
            'active' => $this->active,
        ];
    }
}
