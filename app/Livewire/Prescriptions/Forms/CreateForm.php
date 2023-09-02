<?php

namespace App\Livewire\Prescriptions\Forms;

use Livewire\Component;
use App\Models\Prescription;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateForm extends Component
{
    use WithFileUploads;

    public $images = [];
    public $delivery_address;
    public $delivery_time;
    public $note;

    public function mount()
    {
        $this->delivery_time = '';
    }

    protected $rules = [
        'images' => 'array|max:5',
        'images.*' => 'image|max:2048',
        'delivery_address' => 'required',
        'delivery_time' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function store()
    {   
        $validatedData = $this->validate($this->rules);;
        $data['delivery_address'] = $this->delivery_address;
        $data['delivery_time'] = $this->delivery_time;
        $data['note'] = $this->note;
        $data['add_by'] = Auth::user()->id;

        foreach ($this->images as $image) {
            $urls[] = $image->store('images', 'public');
        }
        $data['images'] = json_encode($urls);

        $prescription = Prescription::create($data);
        if($prescription){
            return redirect()->route('prescriptions.index')->with('status', 'Prescription created successfully.');  
        }
        return redirect()->route('prescriptions.index')->with('delete', 'Prescription create faild, try again.');       
        
    }

    public function render()
    {
        return view('prescriptions.components.create-form');
    }
}
