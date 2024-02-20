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
        Schema::create('mutualfunds', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->integer('sr_no');
            $table->string('mutual_fund_holder_name');
            $table->integer('mutual_fund_type_id');     //[dropdown provided by team]
            $table->integer('folio_number');
            $table->string('fund_name');
            $table->string('fund_type');
            $table->date('purchase_date');
            $table->integer('amount');
            $table->integer('yearly_amount');
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->date('nominee_dob');
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
        Schema::dropIfExists('mutualfunds');
    }
};
