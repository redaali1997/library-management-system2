<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public const PENDING = 1;
    public const ACCEPTED = 2;
    public const REVERSED = 3;
    public const REFUSED = 4;


    /**
     * Get all of the orders for the Status
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
