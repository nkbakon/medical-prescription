<?php

namespace App\Livewire\Quotations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quotation;

class QuotationTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $quotations = Quotation::search($this->search)
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);
        
        return view('quotations.components.quotation-table', [
            'quotations' => $quotations
        ]);
    }
}
