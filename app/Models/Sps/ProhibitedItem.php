<?php

namespace App\Models\Sps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProhibitedItem extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'prohibited_items';

}
