<?php

namespace App\Livewire\Quotations\Forms;

use Livewire\Component;
use App\Models\Drug;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use App\Models\Prescription;

class EditForm extends Component
{
    public $quotation;
    public $all_drugs;
    public $rows = [''];
    public $index;
    public $quantity;
    public $drug;
    public $prescription;  
    public $total;
    public $status;

    public function rules()
    {
        return [
            'drug.*' => 'required',
            'quantity.*' => 'required',
        ];
    }

    public function mount($quotation)
    {
        $this->all_drugs = Drug::all();
        $this->quotation = $quotation;
        $this->status = $quotation->status;
        if($quotation->prescription_id != null){
            $prescription = Prescription::find($quotation->prescription_id);
            $this->prescription = $prescription;
        }
        $quantities = json_decode($quotation->quantities);
        foreach($quantities as $quantity) {
            $this->quantity[] = $quantity;
        }
        $drug_ids = json_decode($quotation->drug_ids);
        foreach($drug_ids as $drug_id) {
            $this->drug[] = $drug_id;
        }
        foreach($drug_ids as $index => $drug_id) {
            $this->rows[$index] = '';
        }
        
    }

    public function update()
    {
        $this->resetErrorBag('quantity');
        $validatedData = $this->validate($this->rules());
        $validatedData['edit_by'] = Auth::user()->id;

        $data['drug_ids'] = json_encode($validatedData['drug']);
        $data['quantities'] = json_encode($validatedData['quantity']);
        $data['edit_by'] = $validatedData['edit_by'];
        $total = 0;
        foreach($validatedData['drug'] as $index => $drug_id) {
            $drug = Drug::find($drug_id);        
            if($drug){
                $subtotal = 0;
                foreach($validatedData['quantity'] as $quantity_index => $quantity){
                    if($index === $quantity_index){
                        $amounts[] = $drug->price * $quantity;
                        $subtotal = $drug->price * $quantity;
                        $total = $total + $subtotal; 
                    }
                    
                }                  
            }                
        }
        $data['amounts'] = json_encode($amounts);
        $data['total'] = $total;
        $data['status'] = $this->status;

        $allDrugsHaveEnoughStock = true;

        foreach($validatedData['drug'] as $index => $drug_id){
            $drug = Drug::find($drug_id);
            if($drug){
                foreach($validatedData['quantity'] as $quantity_index => $quantity){
                    $quantities = json_decode($this->quotation->quantities);
                    foreach($quantities as $currentquantity_index => $currentquantity) {
                        if ($quantity_index === $currentquantity_index){
                            $difference = $quantity - $currentquantity;
                            if($index === $quantity_index && $drug->stock < $difference) {
                                $this->addError("quantity", "Not enough stock for drug: {$drug->name} (Available $drug->stock only).");
                                $allDrugsHaveEnoughStock = false; // set the flag variable to false
                                break;
                            } else if ($index == $quantity_index) {
                                // do nothing here
                            }
                        }                        
                    }                    
                }
            }
        }

        if ($allDrugsHaveEnoughStock) {
            // update the stock for all drugs
            foreach($validatedData['drug'] as $index => $drug_id){
                $drug = Drug::find($drug_id);
    
                if($drug){
                    foreach($validatedData['quantity'] as $quantity_index => $quantity){
                        $quantities = json_decode($this->quotation->quantities);
                        foreach($quantities as $currentquantity_index => $currentquantity) {
                            if ($quantity_index === $currentquantity_index){
                                $difference = $quantity - $currentquantity;
                                if ($index == $quantity_index) {
                                    $drug->update([
                                        'stock' => $drug->stock - $difference,
                                    ]);                      
                                }
                            }
                        }
                    }
                }
            }
    
            $this->quotation->update($data);
            return redirect()->route('quotations.index')->with('success', 'Quotation updated successfully.');
        } else {
            return back()->withInput()->withErrors(['error' => 'Quotation update failed, try again!']);
        }
    }

    public function render()
    {
        return view('quotations.components.edit-form');
    }
}