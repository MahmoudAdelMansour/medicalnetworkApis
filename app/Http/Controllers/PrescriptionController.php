<?php

namespace App\Http\Controllers;

use App\Http\Resources\PrescriptionResource;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with('user')->latest()->get();
        return PrescriptionResource::collection($prescriptions);
    }

    // GET /api/v1/users/{user}/prescriptions
    public function byUser($user)
    {
        $prescriptions = Prescription::with('user')->where('user_id', $user)->latest()->get();

        return PrescriptionResource::collection($prescriptions);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'file' => ['required', 'file','mimes:pdf,doc,docx,txt,image,jpeg,png,jpg']
        ]);
        $data['file'] = $request->file('file')
            ->store('prescriptions','public');

        return new PrescriptionResource(Prescription::create($data));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load('user');
        return new PrescriptionResource($prescription);
    }

    public function update(Request $request, Prescription $prescription)
    {
        $data = $request->validate([
            'user_id' => ['required', 'exists:users'],
            'file' => ['required', 'file','mimes:pdf,doc,docx,txt,image,jpeg,png,jpg']
        ]);
        $data['file'] = $request->file('file')
            ->store('prescriptions','public');

        $prescription->update($data);

        return new PrescriptionResource($prescription);
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();

        return response()->json();
    }
}
