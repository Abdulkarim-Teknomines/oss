<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInsuranceCompany extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function vehicle_insurance()
    {
    return $this->hasMany(VehicleInsurance::class);
    }
}
