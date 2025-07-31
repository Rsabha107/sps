<?php

namespace App\Models\Cms;

use App\Models\GlobalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = "product_categories";

    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag');
    }
}
