<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    private bool $includePassword = true;

    // withoutPassword / true / false
    public function withoutPassword() : self
    {
        $this->includePassword = false;
        return $this;
    }

    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'type' => $this->type,
            'email_verified_at' => $this->email_verified_at,
            'password' => $this->includePassword ? $this->password : null,
            'prescriptions' => PrescriptionResource::collection($this->whenLoaded('prescriptions')),
        ];
    }
}
