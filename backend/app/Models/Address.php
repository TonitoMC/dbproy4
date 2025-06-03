<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'street',
        'city',
        'postal_code',
        'country',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'address_user')
                    ->withPivot('type', 'is_default');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'address_supplier');
    }
}
