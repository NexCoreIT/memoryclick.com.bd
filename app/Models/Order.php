<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'tran_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postcode',
        'country',
        'amount',
        'currency',
        'status',
        'val_id',
        'bank_tran_id',
        'card_type',
        'card_no',
        'card_issuer',
        'card_brand',
        'card_issuer_country',
        'currency_amount',
        'currency_rate',
        'base_fair',
        'value_a',
        'value_b',
        'value_c',
        'value_d',
        'response_data',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}