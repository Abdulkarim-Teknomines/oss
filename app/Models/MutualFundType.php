<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutualFundType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    public function mutualfund()
    {
    return $this->hasMany(Mutualfund::class);
    }
}
