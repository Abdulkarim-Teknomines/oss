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
        Schema::create('vehicle_insurances', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('sr_no');
            $table->integer('vehicle_category_id');
            $table->string('vehicle_number');     //[dropdown provided by team]
            $table->string('vehicle_name');
            $table->string('chasis_number');
            $table->string('insurance_company_name');
            $table->integer('policy_number');
            $table->integer('insurance_policy_type_id');
            $table->integer('policy_premium');
            $table->string('vehicle_owner_name');
            $table->date('policy_start_date');
            $table->date('policy_end_date');
            $table->string('agent_name')->nullable();
            $table->integer('agent_mobile_number')->nullable();  
            $table->string('other_details')->nullable();      
            $table->integer('jan')->default(0);
            $table->integer('feb')->default(0);
            $table->integer('mar')->default(0);
            $table->integer('apr')->default(0);
            $table->integer('may')->default(0);
            $table->integer('jun')->default(0);
            $table->integer('jul')->default(0);
            $table->integer('aug')->default(0);
            $table->integer('sep')->default(0);
            $table->integer('oct')->default(0);
            $table->integer('nov')->default(0);
            $table->integer('dec')->default(0);
            $table->integer('single')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_insurances');
    }
};
