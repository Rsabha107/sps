<?php

namespace App\Models\Sps;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ItemStatus extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'item_statuses';

}
