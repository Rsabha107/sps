<?php

namespace App\Models\Cms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderNumGen extends Model
{
    use HasFactory;
    protected $table = 'order_number_gen';
    protected $guarded = [];
}
