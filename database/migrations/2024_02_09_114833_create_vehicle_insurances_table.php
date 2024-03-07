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
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->bigInteger('sr_no');
            $table->integer('vehicle_category_id');
            $table->string('vehicle_number');     
            $table->string('vehicle_name');
            $table->string('chasis_number');
            $table->integer('company_name_id');
            $table->string('policy_number');
            $table->integer('insurance_policy_type_id');
            $table->bigInteger('policy_premium');
            $table->string('vehicle_owner_name');
            $table->date('policy_start_date');
            $table->date('policy_end_date');
            $table->string('agent_name')->nullable();
            $table->bigInteger('agent_mobile_number')->nullable();  
            $table->string('other_details')->nullable();
            $table->string('category')->nullable();      
            $table->bigInteger('jan')->default(0);
            $table->bigInteger('feb')->default(0);
            $table->bigInteger('mar')->default(0);
            $table->bigInteger('apr')->default(0);
            $table->bigInteger('may')->default(0);
            $table->bigInteger('jun')->default(0);
            $table->bigInteger('jul')->default(0);
            $table->bigInteger('aug')->default(0);
            $table->bigInteger('sep')->default(0);
            $table->bigInteger('oct')->default(0);
            $table->bigInteger('nov')->default(0);
            $table->bigInteger('dec')->default(0);
            $table->bigInteger('single')->default(0); 
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
