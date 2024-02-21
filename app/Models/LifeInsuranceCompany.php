<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LifeInsuranceCompany extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function life_insurance()
    {
    return $this->hasMany(Lifeinsurance::class);
    }
    
}
