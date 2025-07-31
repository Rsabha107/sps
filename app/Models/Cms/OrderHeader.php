<?php

namespace App\Models\Cms;

use App\Models\GeneralSettings\CompanyAddress;
use App\Models\GeneralSettings\Currency;
use App\Models\Cms\OrderNumGen;
use App\Models\GeneralSettings\GlobalAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class OrderHeader extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'order_headers';

    public static function boot()
    {

        parent::boot();

        // static::addGlobalScope(new NonArchivedScope);

        static::creating(function ($model) {
            Log::info('Creating OrderHeader model', ['model' => $model]);
            $generated_number = OrderNumGen::firstOrFail();
            $last_number = $generated_number->max('last_number') + 1;
            $generated_number->update(['last_number' => $last_number]);

            $model->order_number = 'ORD' . '-' . str_pad($last_number, 5, '0', STR_PAD_LEFT);
        });
    }

    public function created_by_who()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contractor()
    {
        return $this->belongsTo(Contractor::class, 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class, 'order_header_id', 'id');
    }

    public function business_address()
    {
        return $this->belongsTo(CompanyAddress::class, 'deliver_to_address_id');
    }

    public function attachments()
    {
        return $this->hasMany(GlobalAttachment::class, 'model_id')->where('model_name', 'ORDERS');
    }
}
