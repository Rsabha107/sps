<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLinesVoucher extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'order_lines_vouchers';

    public function orderLine()
    {
        return $this->belongsTo(OrderLine::class, 'order_line_id', 'id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id', 'id');
    }
    public function redemption_venue()
    {
        return $this->belongsTo(Venue::class, 'redemption_venue_id', 'id');
    }


}
