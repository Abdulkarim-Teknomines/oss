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
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->bigInteger('sr_no');
            $table->string('policy_holder_name');
            $table->date('birth_date');
            $table->date('policy_start_date');
            $table->integer('company_name_id');     //[dropdown provided by team]
            $table->string('policy_number');
            $table->bigInteger('sum_assured');
            $table->string('plan_name');
            $table->integer('plan_type_id');         //[dropdown][regular / lppt / single]
            $table->integer('ppt');
            $table->date('ppt_end_date');
            $table->integer('policy_mode_id');     // [dropdown]	[monthly/quarterly/hlaf yearly/yearly/single]
            $table->bigInteger('premium_amount');
            $table->bigInteger('yearly_premium_amount');
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->string('nominee_dob');
            $table->string('agent_name')->nullable();
            $table->string('agent_mobile_number')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('branch_contact_no')->nullable();
            $table->string('other_details')->nullable();
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
        Schema::dropIfExists('lifeinsurances');
    }
};
