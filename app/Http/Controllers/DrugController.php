<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Drug;

class DrugController extends Controller
{
    
    public function index()
    {        
        return view('drugs.index');
    }

    public function create()
    {
        return view('drugs.create');
    }

    public function edit(Drug $drug)
    {
        return view('drugs.edit', compact('drug'));
    }

    public function destroy(Request $request)
    {
        $drug = Drug::find($request->data_id);
        if($drug)
        {
            $drug->delete();
            return redirect()->route('drugs.index')->with('delete', 'Drug deleted successfully.');
        }
        else
        {
            return redirect()->route('drugs.index')->with('delete', 'No Drug Found!.');
        }    
    }

}
