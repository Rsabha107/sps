<?php

namespace App\Models\Sps;

use App\Models\Setting\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StoredItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'stored_items';

    public function prohibited_item()
    {
        return $this->belongsTo(ProhibitedItem::class, 'item_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

}
