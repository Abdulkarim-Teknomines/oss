<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Mediclaim extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'sr_no',
        'policy_holder_name',
        'birth_date',
        'policy_start_date',
        'company_name_id',
        'user_id',
        'policy_number',
        'policy_type_id',
        'sum_assured',
        'policy_name',
        'policy_mode',
        'premium_amount',
        'yearly_premium_amount',
        'agent_name',
        'agent_mobile_number',
        'branch_name',
        'branch_address',
        'branch_contact_no'
    ];

}

