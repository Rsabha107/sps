<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePeriod extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'service_periods';

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
}
