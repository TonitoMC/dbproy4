<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AddressSupplier extends Pivot
{
    public $timestamps = false;

    protected $table = 'address_supplier';

    protected $fillable = [
        'address_id',
        'supplier_id',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
