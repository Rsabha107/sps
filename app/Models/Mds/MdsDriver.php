<?php

namespace App\Models\Mds;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MdsDriver extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table="mds_drivers";


    public function status()
    {
        return $this->belongsTo(DriverStatus::class, 'status_id');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => "{$this->first_name} {$this->last_name}",
            set: fn ($value) => [
                'first_name' => explode(' ', $value)[0],
                'last_name' => explode(' ', $value)[1] ?? ''
            ]
        );
    }

}
