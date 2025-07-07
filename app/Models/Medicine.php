<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    public function inventoryMovements()
    {
        return $this->hasMany(InventoryMovement::class);
    }

    public function dispensations()
    {
        return $this->hasMany(Dispensation::class);
    }
}
