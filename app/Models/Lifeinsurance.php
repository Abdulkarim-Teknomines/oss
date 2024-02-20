<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\CompanyName;
use App\Models\Ppt;
use App\Models\User;
use App\Models\PolicyMode;

class Lifeinsurance extends Model

{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'parent_id',
        'sr_no',
        'policy_holder_name',
        'birth_date',
        'policy_start_date',
        'company_name_id',
        'policy_number',
        'sum_assured',
        'user_id',
        'plan_name',
        'ppt_id',
        'policy_term',
        'premium_mode_id',
        'premium_amount',
        'yearly_premium_amount',
        'nominee_name',
        'nominee_relation',
        'nominee_dob',
        'agent_name',
        'agent_mobile_number',
        'branch_name',
        'branch_address',
        'branch_contact_no',
        'jan',
        'feb',
        'mar',
        'apr',
        'may',
        'jun',
        'jul',
        'aug',
        'sep',
        'oct',
        'nov',
        'dec',
        'single'
    ];
    public function company_name()
    {
        return $this->belongsTo(CompanyName::class);
    }
    public function policy_mode()
    {
        return $this->belongsTo(PolicyMode::class);
    }
    public function ppt()
    {
        return $this->belongsTo(ppt::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

