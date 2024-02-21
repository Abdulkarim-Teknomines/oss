<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\MediclaimCompany;
use App\Models\PolicyType;
use App\Models\User;
use App\Models\PolicyMode;
class Mediclaim extends Model
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
        'user_id',
        'policy_number',
        'policy_type_id',
        'sum_assured',
        'policy_name',
        'policy_mode_id',
        'premium_amount',
        'yearly_premium_amount',
        'agent_name',
        'agent_mobile_number',
        'branch_name',
        'branch_address',
        'branch_contact_no',
        'other_details',
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
        return $this->belongsTo(MediclaimCompany::class);
    }
    public function policy_type()
    {
        return $this->belongsTo(PolicyType::class);
    }
    public function policy_mode()
    {
        return $this->belongsTo(PolicyMode::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

