<?php

namespace App\Http\Controllers;

use App\Http\Resources\PharmacyResource;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index()
    {
        return PharmacyResource::collection(Pharmacy::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable'],
            'description' => ['nullable'],
            'logo' => ['nullable'],
        ]);

        return new PharmacyResource(Pharmacy::create($data));
    }

    public function show(Pharmacy $pharmacy)
    {
        return new PharmacyResource($pharmacy);
    }

    public function update(Request $request, Pharmacy $pharmacy)
    {
        $data = $request->validate([
            'name' => ['nullable'],
            'description' => ['nullable'],
            'logo' => ['nullable'],
        ]);

        $pharmacy->update($data);

        return new PharmacyResource($pharmacy);
    }

    public function destroy(Pharmacy $pharmacy)
    {
        $pharmacy->delete();

        return response()->json();
    }
}
