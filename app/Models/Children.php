<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'birth_date',
        'user_id'
    ];
    public static function getUserNameById($id){
        return User::where('id', $id)->pluck('name')->first();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
