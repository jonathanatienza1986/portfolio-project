<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('phone');
            $table->string('birth_place')->nullable();
            $table->string('birth_date');
            $table->string('sex')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('license_link');
            $table->string('license_id_no')->unique();
            $table->string('license_expity_date');
            $table->string('govt_id_link')->nullable();
            $table->string('govt_id_no')->nullable();
            $table->string('govt_id_type')->nullable();
            $table->string('portrait_link')->nullable();
            $table->string('pic1_link')->nullable();
            $table->string('pic2_link')->nullable();
            $table->string('pic3_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
