<?php

namespace App\Livewire\Drugs\Forms;

use Livewire\Component;
use App\Models\Drug;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    public $name;
    public $stock;
    public $price;

    protected $rules = [
        'name' => 'required',
        'stock' => 'required',
        'price' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {   
        $validatedData = $this->validate($this->rules);;
        $data['name'] = $this->name;
        $data['stock'] = $this->stock;
        $data['price'] = $this->price;
        $data['add_by'] = Auth::user()->id;

        $drug = Drug::create($data);
        if($drug){
            return redirect()->route('drugs.index')->with('status', 'Drug created successfully.');  
        }
        return redirect()->route('drugs.index')->with('delete', 'Drug create faild, try again.');       
        
    }

    public function render()
    {
        return view('drugs.components.create-form');
    }
}
