<?php

namespace App\Http\Resources;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Medicine */
class MedicineResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'brand_names' => $this->brand_names,
            'active_ingredient' => $this->active_ingredient,
            'strength' => $this->strength,
            'strength_unit' => $this->strength_unit,
            'manufacturer' => $this->manufacturer,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'pharmacy_id' => $this->pharmacy_id,
            'pharmacy' => new PharmacyResource($this->whenLoaded('pharmacy'))
        ];
    }
}
