<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class AddressUser extends Pivot
{
    public $timestamps = false;

    protected $table = 'address_user';

    protected $fillable = [
        'address_id',
        'user_id',
        'type',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
