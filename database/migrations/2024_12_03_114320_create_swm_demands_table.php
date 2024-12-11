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
        Schema::create('swm_demands', function (Blueprint $table) {
            $table->id();
            $table->integer('consumer_id');
            $table->integer('total_tax');
            $table->date('payment_from');
            $table->date('payment_to');
            $table->integer('paid_status');
            $table->string('last_payment_id');
            $table->integer('user_id');
            $table->timestamp('stampdate');
            $table->date('demand_date');
            $table->integer('is_deactivate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('swm_demands');
    }
};


