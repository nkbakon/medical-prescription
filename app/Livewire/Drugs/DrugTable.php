<?php

namespace App\Livewire\Drugs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Drug;

class DrugTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $drugs = Drug::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        
        return view('drugs.components.drug-table', [
            'drugs' => $drugs
        ]);
    }
}
