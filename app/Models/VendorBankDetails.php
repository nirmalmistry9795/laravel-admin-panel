<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBankDetails extends Model
{
    use HasFactory;
    protected $table = 'vendors_bank_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'vendor_id',
        'account_holder_name',
        'bank_name',
        'account_number',
        'bank_ifsc_code'
    ];
}
