<?php

namespace App\Models\Setting;

use App\Models\GlobalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class storageType extends Model
{
    use HasFactory;
    protected $table="storage_types";
    protected $guarded = [];


    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag');
    }
}
