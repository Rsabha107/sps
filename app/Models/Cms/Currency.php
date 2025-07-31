<?php

namespace App\Models\Cms;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = "currencies";

    public function getCurrencySymbolAttribute()
    {
        return $this->code .' ('. $this->symbol . ')';
    }
}
