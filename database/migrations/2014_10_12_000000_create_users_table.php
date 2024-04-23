<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->string('user_id')->nullable();
            $table->bigInteger('mobile_number');
            $table->bigInteger('emergency_contact_number')->nullable();
            $table->string('pancard_number')->nullable();
            $table->string('adharcard_number')->nullable();
            $table->string('name');
            $table->string('blood_group_id')->nullable();
            $table->string('department_id')->nullable();
            $table->integer('country_id');
            $table->integer('state_id');
            $table->integer('city_id');
            $table->date('birth_date');
            $table->string('address');
            $table->string('middle_name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('password');
            $table->integer('isActive');        // 0 active // 1 inactive
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
