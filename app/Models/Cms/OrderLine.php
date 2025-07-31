<?php

namespace App\Models\Cms;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'order_lines';

    protected $appends = ['line_total'];

    public function getLineTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function created_by_who()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'venue_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function order_header()
    {
        return $this->belongsTo(OrderHeader::class, 'order_header_id');
    }

    public function service_time()
    {
        return $this->belongsTo(ServiceTime::class, 'service_time_id');
    }

    public function service_location()
    {
        return $this->belongsTo(ServiceLocation::class, 'service_location_id');
    }

    public function vouchers()
    {
        return $this->hasMany(OrderLinesVoucher::class, 'order_line_id', 'id');
    }
}
