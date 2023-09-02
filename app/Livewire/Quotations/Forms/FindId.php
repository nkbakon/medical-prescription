<?php

namespace App\Livewire\Quotations\Forms;

use Livewire\Component;
use App\Models\Prescription;

class FindId extends Component
{
    public $prescription_id;
    public $prescription;

    public $rules = [
        'prescription_id' => 'required',
    ];

    public function find()
    {
        $this->validate([
            'prescription_id' => 'required',
        ]);

        $prescription = Prescription::find($this->prescription_id);
        if ($prescription) {
            $this->prescription = $prescription;
            session(['prescription' => $this->prescription]);
            return redirect()->route('quotations.create');
        } else {
            $this->prescription = null;
            session()->put('prescription', null);
            return redirect()->route('quotations.create');
        }
    }

    public function mount()
    {
        $this->prescription = session('prescription');                
    }

    public function render()
    {
        $prescriptions = [];

        if ($this->prescription && $this->prescription->id) {
            $prescriptions = Prescription::where('id', $this->prescription->id)->get();
        }

        return view('quotations.components.find-id', [
            'prescriptions' => $prescriptions
        ]);
    }
}