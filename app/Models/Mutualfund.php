<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Mutualfund extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'user_id',
        'sr_no',
        'mutual_fund_holder_name',
        'multual_fund_type_id',
        'folio_number',
        'fund_name',
        'fund_type',
        'purchase_date',
        'amount',
        'yearly_amount',
        'nominee_name',
        'nominee_relation',
        'nominee_dob',
        'agent_name',
        'agent_mobile_number',
    ];
}

