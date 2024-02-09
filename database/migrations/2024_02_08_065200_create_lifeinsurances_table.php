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
        Schema::create('lifeinsurances', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('sr_no');
            $table->string('policy_holder_name');
            $table->date('birth_date');
            $table->date('policy_start_date');
            $table->integer('company_name_id');     //[dropdown provided by team]
            $table->integer('policy_number');
            $table->integer('sum_assured');
            $table->string('plan_name');
            $table->integer('ppt_id');         //[dropdown][regular / lppt / single]
            $table->integer('policy_term');
            $table->integer('premium_mode_id');     // [dropdown]	[monthly/quarterly/hlaf yearly/yearly/single]
            $table->integer('premium_amount');
            $table->integer('yearly_premium_amount');
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->string('nominee_dob');
            $table->string('agent_name')->nullable();
            $table->string('agent_mobile_number')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('branch_contact_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lifeinsurances');
    }
};
