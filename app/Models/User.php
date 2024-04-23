<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Country;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'middle_name',
        'surname',
        'mobile_number',
        'emergency_contact_number',
        'pancard_number',
        'adharcard_number',
        'email',
        'address',
        'parent_id',
        'blood_group_id',
        'department_id',
        'country_id',
        'state_id',
        'city_id',
        'birth_date',
        'isActive',
        'expiry_date',
        'password'
    ];
    
    public static function getUserNameById($id){
        return User::where('id', $id)->pluck('name')->first();
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function member()
    {
        return $this->hasOne(Member::class);
    }
    public function children(){
        return $this->hasMany(Children::class);
    }
    public function mediclaim()
    {
    return $this->hasMany(Mediclaim::class);
    }
    public function vehicle_insurance()
    {
    return $this->hasMany(VehicleInsurance::class);
    }
    public function mutual_fund()
    {
    return $this->hasMany(Mutualfund::class);
    }
    public function life_insurance()
    {
    return $this->hasMany(Lifeinsurance::class);
    }
    public function users()
    {
    return $this->hasMany(User::class);
    }
    public function recursivePosts()
    {
        return $this->hasManyOfDescendantsAndSelf(Mediclaim::class);
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}