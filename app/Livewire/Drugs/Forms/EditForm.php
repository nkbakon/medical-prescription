<?php

namespace App\Livewire\Drugs\Forms;

use Livewire\Component;
use App\Models\Drug;
use Illuminate\Support\Facades\Auth;

class EditForm extends Component
{
    public $drug;
    public $name;
    public $stock;
    public $price;

    public function rules()
    {
        return [
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
        ];
    }

    public function mount($drug)
    {
        $this->drug = $drug;
        $this->name = $drug->name;
        $this->stock = $drug->stock;
        $this->price = $drug->price;
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $data['name'] = $this->name;
        $data['stock'] = $this->stock;
        $data['price'] = $this->price;
        $data['edit_by'] = Auth::user()->id;
        
        $this->drug->update($data);        
        return redirect()->route('drugs.index')->with('success', 'Drug updated successfully.');
    }

    public function render()
    {
        return view('drugs.components.edit-form');
    }
}