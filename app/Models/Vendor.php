<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $table = 'vendors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'address',
        'city_id',
        'state_id',
        'country_id',
        'pincode_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor_bank_details()
    {
        return $this->hasOne(VendorBankDetails::class, 'vendor_id');
    }

    public function vendor_business_details()
    {
        return $this->hasOne(VendorBusinessDetails::class, 'vendor_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function pincode()
    {
        return $this->belongsTo(Pincode::class, 'pincode_id');
    }
}
