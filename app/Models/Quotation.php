<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Prescription;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotations';

    protected $fillable = [
        'drug_ids',
        'quantities',
        'amounts',
        'total',
        'prescription_id',
        'status',
        'add_by',
        'edit_by',
        'created_at',
        'updated_at',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id', 'id');
    }

    public function addby()
    {
        return $this->belongsTo(User::class, 'add_by', 'id');
    }

    public function editby()
    {
        if (!empty($this->edit_by)){
            return $this->belongsTo(User::class, 'edit_by', 'id');
        }
        
        return $this->belongsTo(User::class, 'add_by', 'id');
    }

    public static function search($search)
    {
        return empty($search)
        ? static::query()
        : static::query()->where('id', 'like', '%' . $search . '%')
            ->orWhereHas('addby', function($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%');
            });
    }

    public function getStatusColorAttribute()
    {
        return [
            'Pending' => 'yellow',
            'Accepted' => 'green',
            'Rejected' => 'red',
        ][$this->status] ?? 'cool-gray';
    }
}
