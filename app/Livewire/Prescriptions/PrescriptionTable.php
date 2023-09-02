<?php

namespace App\Livewire\Prescriptions;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prescription;

class PrescriptionTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $prescriptions = Prescription::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        
        return view('prescriptions.components.prescription-table', [
            'prescriptions' => $prescriptions
        ]);
    }
}
