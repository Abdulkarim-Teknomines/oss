<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use App\Models\VehicleCategory;
use App\Models\InsurancePolicyType;
use App\Models\VehicleInsuranceCompany;

class VehicleInsurance extends Model
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'parent_id',
        'user_id',
        'sr_no',
        'vehicle_category_id',
        'vehicle_number',
        'vehicle_name',
        'company_name_id',
        'policy_number',
        'chasis_number',
        'insurance_policy_type_id',
        'policy_premium',
        'vehicle_owner_name',
        'policy_start_date',
        'policy_end_date',
        'agent_name',
        'agent_mobile_number',
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
    public function vehicle_category()
    {
        return $this->belongsTo(VehicleCategory::class);
    }
    public function insurance_policy_type()
    {
        return $this->belongsTo(InsurancePolicyType::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }   
    public function company_name()
    {
        return $this->belongsTo(VehicleInsuranceCompany::class);
    }
}
