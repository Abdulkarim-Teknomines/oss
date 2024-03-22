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
            $table->bigInteger('sr_no');
            $table->string('mutual_fund_holder_name');
            $table->integer('mutual_fund_type_id');     //[dropdown provided by team]
            $table->string('folio_number');
            $table->string('fund_name');
            $table->string('fund_type');
            $table->date('purchase_date');
            $table->bigInteger('amount');
            $table->bigInteger('yearly_amount');
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->date('nominee_dob');
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
        Schema::dropIfExists('mutualfunds');
    }
};
