<?php

namespace App\Http\Controllers;

use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with('pharmacy')->latest()->get();
        return MedicineResource::collection($medicines);
    }

    // GET /api/v1/pharmacies/{pharmacy}/medicines
    public function byPharmacy($pharmacyId)
    {
        $medicines = Medicine::where('pharmacy_id', $pharmacyId)->latest()->get();
        return MedicineResource::collection($medicines);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable'],
            'description' => ['nullable'],
            'brand_names' => ['nullable'],
            'active_ingredient' => ['nullable'],
            'strength' => ['nullable'],
            'strength_unit' => ['nullable'],
            'manufacturer' => ['nullable'],
            'pharmacy_id' => ['nullable', 'exists:pharmacies'],
        ]);

        return new MedicineResource(Medicine::create($data));
    }

    public function show(Medicine $medicine)
    {
        $medicine->load('pharmacy');
        return new MedicineResource($medicine);
    }

    public function update(Request $request, Medicine $medicine)
    {
        $data = $request->validate([
            'name' => ['nullable'],
            'description' => ['nullable'],
            'brand_names' => ['nullable'],
            'active_ingredient' => ['nullable'],
            'strength' => ['nullable'],
            'strength_unit' => ['nullable'],
            'manufacturer' => ['nullable'],
            'pharmacy_id' => ['nullable', 'exists:pharmacies'],
        ]);

        $medicine->update($data);

        return new MedicineResource($medicine);
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return response()->json();
    }
}
