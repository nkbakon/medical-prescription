<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\Drug;

class QuotationController extends Controller
{
    public function index()
    {        
        return view('quotations.index');
    }

    public function create()
    {
        return view('quotations.create');
    }

    public function edit(Quotation $quotation)
    {
        return view('quotations.edit', compact('quotation'));
    }

    public function destroy(Request $request)
    {
        $quotation = Quotation::find($request->data_id);
        if($quotation)
        {
            $drug_ids = json_decode($quotation->drug_ids);
            foreach($drug_ids as $index => $drug_id){
                $drug = Drug::find($drug_id);
                if($drug){
                    $quantities = json_decode($quotation->quantities);
                    foreach($quantities as $quantity_index => $quantity) {
                        if ($index == $quantity_index) {
                            $drug->update([
                                'stock' => $drug->stock + $quantity,
                            ]);                     
                        }
                    }
                }
            }
            $quotation->delete();
            return redirect()->route('quotations.index')->with('delete', 'Quotation deleted successfully.');
        }
        else
        {
            return redirect()->route('quotations.index')->with('delete', 'No Quotation Found!.');
        }    
    }

    public function view(Quotation $quotation)
    {
        return view('quotations.view', compact('quotation'));
    }
}
