<?php

namespace App\Livewire\Prescriptions\Forms;

use Livewire\Component;
use App\Models\Prescription;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditForm extends Component
{
    use WithFileUploads;

    public $prescription;
    public $images = [];
    public $delivery_address;
    public $delivery_time;
    public $note;
    public $updateimages = [];

    public function rules()
    {
        return [
            'delivery_address' => 'required',
            'delivery_time' => 'required',
        ];
    }

    public function mount($prescription)
    {
        $this->prescription = $prescription;
        $this->images = $prescription->images;
        $this->delivery_address = $prescription->delivery_address;
        $this->delivery_time = $prescription->delivery_time;
        $this->note = $prescription->note;
    }

    public function removeImgs()
    {
        $images = json_decode($this->images);
        foreach ($images as $image) {
            Storage::disk('public')->delete($image);
        }
        $data['images'] = '';
        $this->prescription->update($data);
        return redirect()->route('prescriptions.edit', $this->prescription->id);
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());
        $data['delivery_address'] = $this->delivery_address;
        $data['delivery_time'] = $this->delivery_time;
        $data['note'] = $this->note;
        $data['edit_by'] = Auth::user()->id;

        if($this->images == ''){
            foreach ($this->updateimages as $image) {
                $urls[] = $image->store('images', 'public');
            }
            $data['images'] = json_encode($urls);
        }
        
        $this->prescription->update($data);        
        return redirect()->route('prescriptions.index')->with('success', 'Prescription updated successfully.');
    }

    public function render()
    {
        return view('prescriptions.components.edit-form');
    }
}
