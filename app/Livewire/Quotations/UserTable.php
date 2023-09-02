<?php

namespace App\Livewire\Quotations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quotation;
use App\Models\Prescription;
use Illuminate\Support\Facades\Auth;

class UserTable extends Component
{
    use WithPagination;

    public $perPage = 15;
    public $search = '';
    public $orderBy = 'id';
    public $orderAsc = false;

    public function render()
    {
        $user = Auth::user()->id;
        $query = Quotation::query();
        $prescription = Prescription::where('add_by', $user)->first();

        if ($prescription) {
            $query->where('prescription_id', $prescription->id);
        }

        $quotations = $query->where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->orWhere('total', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('quotations.components.user-table', [
            'quotations' => $quotations
        ]);
    }
}
