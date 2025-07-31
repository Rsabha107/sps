<?php

namespace App\Models\Cms;

use App\Models\GlobalStatus;
use App\Models\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceTime extends Model
{
    use HasFactory;
    protected $table = "service_times";

        public function getServiceTimeConcatAttribute()
    {
        return $this->title. ' ('. $this->service_time_range .')';
    }

    public function active_status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag_id');
    }

}
