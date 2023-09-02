<?php

namespace App\Livewire\Prescriptions;

use Livewire\Component;
use Livewire\WithPagination;
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
        $query = Prescription::query();

        if ($user) {
            $query->where('add_by', $user);
        }

        $prescriptions = $query->where(function ($query) {
            $query->where('id', 'like', '%' . $this->search . '%')
                ->orWhere('delivery_address', 'like', '%' . $this->search . '%')
                ->orWhere('delivery_time', 'like', '%' . $this->search . '%');
        })
        ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
        ->paginate($this->perPage);

        return view('prescriptions.components.user-table', [
            'prescriptions' => $prescriptions
        ]);
    }
}
