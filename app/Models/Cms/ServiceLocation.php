<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLocation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table='service_locations';

    public function product()
    {
        return $this->belongsTo(OrderLine::class, 'service_location_id', 'id');
    }
}
