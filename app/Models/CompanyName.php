<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyName extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function mediclaim()
    {
    return $this->hasMany(Mediclaim::class);
    }
    public function life_insurance()
    {
    return $this->hasMany(LifeInsurance::class);
    }
}
