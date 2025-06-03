<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function addresses()
    {
        return $this->belongsToMany(Address::class, 'address_supplier');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot('cost_price', 'is_primary');
    }
}
