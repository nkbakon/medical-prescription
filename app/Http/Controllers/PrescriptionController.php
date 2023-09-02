<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use Illuminate\Support\Facades\Storage;

class PrescriptionController extends Controller
{
    
    public function index()
    {        
        return view('prescriptions.index');
    }

    public function create()
    {
        return view('prescriptions.create');
    }

    public function edit(Prescription $prescription)
    {
        return view('prescriptions.edit', compact('prescription'));
    }

    public function destroy(Request $request)
    {
        $prescription = Prescription::find($request->data_id);
        if($prescription)
        {
            $images = json_decode($prescription->images);
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }            
            $prescription->delete();
            return redirect()->route('prescriptions.index')->with('delete', 'Prescription deleted successfully.');
        }
        else
        {
            return redirect()->route('prescriptions.index')->with('delete', 'No Prescription Found!.');
        }    
    }

    public function view(Prescription $prescription)
    {
        return view('prescriptions.view', compact('prescription'));
    }

}