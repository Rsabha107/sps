<?php

namespace App\Models\Cms;

use App\Models\GlobalStatus;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag_id');
    }

    public function unit_type()
    {
        return $this->belongsTo(ItemUnitType::class, 'unit_type_id');
    }
}
