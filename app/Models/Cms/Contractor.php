<?php

namespace App\Models\Cms;

use App\Models\GlobalStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table='contractors';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function venues()
    {
        return $this->belongsToMany(Venue::class, 'contractor_venue', 'contractor_id', 'venue_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'contractor_event', 'contractor_id', 'event_id');
    }

        public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function status()
    {
        return $this->belongsTo(GlobalStatus::class, 'active_flag', 'id');
    }

}
