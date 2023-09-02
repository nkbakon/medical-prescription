<?php

namespace App\Livewire\Quotations\Forms;

use Livewire\Component;
use App\Models\Drug;
use App\Models\Quotation;
use Illuminate\Support\Facades\Auth;
use App\Models\Prescription;

class CreateForm extends Component
{
    public $prescription;
    public $index;
    public $rows = [''];
    public $drugs = [];
    public $quantities = [];
    public $amounts = [];
    public $total;
    public $x = 0;

    public function mount()
    {        
        $this->drugs[$this->x] = '';
    }

    public function addRow()
    {
        $this->rows[] = '';
        $x = $this->x + 1;
        $this->drugs[$x] = '';
        $this->x = $x;
        $this->render();
    }

    public function removeRow($index)
    {
        if($index != 0)
        {
            unset($this->rows[$index]);
            $this->rows = array_values($this->rows);
            $index = $index - 1;
            $x = $this->x - 1;
            $this->x = $x;
            $this->quantities[$index+1] = '';
            $this->drugs[$index+1] = '';
            $this->render();
        }
    }

    protected $rules = [
        'drugs' => 'required|array',
        'drugs.*' => 'required',
        'quantities' => 'required|array',
        'quantities.*' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {
        $this->resetErrorBag('quantities');
        $this->drugs = array_filter($this->drugs);
        $this->quantities = array_filter($this->quantities);
        $data['drug_ids'] = json_encode($this->drugs);
        $data['quantities'] = json_encode($this->quantities);
        $data['add_by'] = Auth::user()->id;
        $data['prescription_id'] = $this->prescription->id;

        $drugQuantities  = [];

        $allDrugsHaveEnoughStock = true;
        $tempstock = [];
                
        foreach($this->drugs as $drug_index => $drug_id){
            $drug = Drug::find($drug_id);
            $tempstock[$drug_id] = isset($tempstock[$drug_id]) ? $tempstock[$drug_id] + $this->quantities[$drug_index] : $this->quantities[$drug_index];

            if($drug){
                $quantity = $this->quantities[$drug_index];
                if ($drug->stock < $quantity || $drug->stock < $tempstock[$drug_id]) {
                    $this->addError("quantities", "Not enough stock for drug: {$drug->name} (Available $drug->stock only).");
                    $allDrugsHaveEnoughStock = false; // set the flag variable to false
                    break;
                }

                $key = array_search($drug_id, array_column($drugQuantities, 'id'));

                if ($key !== false) {
                    $drugQuantities[$key]['quantity'] += $quantity;
                }
                else {
                    $drugQuantities[] = [
                        'id' => $drug_id,
                        'quantity' => $quantity,
                    ];
                }             
            }
        }
        
        if ($allDrugsHaveEnoughStock) {            
            // update the stock for all drugs
            foreach($drugQuantities as $drugQuantity) {
                $drug = Drug::find($drugQuantity['id']);        
                if($drug){
                    $drug->update([
                        'stock' => $drug->stock - $drugQuantity['quantity'],
                    ]);                    
                }                
            }
        
            // update the $data array with the drug ids and quantities
            $data['drug_ids'] = json_encode(array_column($drugQuantities, 'id'));
            $data['quantities'] = json_encode(array_column($drugQuantities, 'quantity'));
            $total = 0;
            foreach($drugQuantities as $drugQuantity) {
                $drug = Drug::find($drugQuantity['id']);        
                if($drug){
                    $subtotal = 0;
                    $amounts[] = $drug->price * $drugQuantity['quantity'];
                    $subtotal = $drug->price * $drugQuantity['quantity'];
                    $total = $total + $subtotal;                   
                }                
            }
            $data['amounts'] = json_encode($amounts);
            $data['total'] = $total;
            $quotation = Quotation::create($data);
        }
        
        if($this->getErrorBag()->any()){
            return; // do not redirect if there are errors
        }        

        if($quotation){
            return redirect()->route('quotations.index')->with('status', 'Quotation sent successfully.');  
        }
        return redirect()->route('quotations.index')->with('delete', 'Quotation sending failed, try again.');       
        
    }

    public function render()
    {
        $all_drugs = Drug::all();
        return view('quotations.components.create-form', compact('all_drugs'));
    }
}