<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBusinessDetails extends Model
{
    use HasFactory;
    protected $table = 'vendors_business_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'vendor_id',
        'shop_name',
        'shop_address',
        'city_id',
        'state_id',
        'country_id',
        'pincode_id',
        'shop_mobile',
        'shop_website',
        'shop_email',
        'address_proof',
        'address_proof_image',
        'business_license_number',
        'gst_number',
        'pan_number'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
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
