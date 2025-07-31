<?php

namespace App\Models\Cms;

use App\Models\GlobalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUnitType extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table='product_unit_types';
    
    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag');
    }
}
