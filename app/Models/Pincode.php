<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use HasFactory;
    protected $table = 'pincodes';
    protected $primaryKey = 'id';
    protected $fillable = [
        // 'state_id',
        'city_id',
        'pincode',
        'area'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
