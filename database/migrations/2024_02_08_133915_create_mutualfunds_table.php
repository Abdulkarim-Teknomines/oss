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
            $table->integer('user_id');
            $table->integer('sr_no');
            $table->string('mutual_fund_holder_name');
            $table->integer('multual_fund_type_id');     //[dropdown provided by team]
            $table->string('folio_number');
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
