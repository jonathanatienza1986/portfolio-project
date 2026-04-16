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
        Schema::create('a_i_chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(-10);
            $table->bigInteger('chatbot_id')->default(-10);
            $table->boolean('is_chathead')->default(false);
            $table->boolean('is_analyzed')->default(false);
            $table->boolean('is_error')->default(false);
            $table->string('role')->default("user")->nullable();
            $table->longText('message')->nullable();
            $table->string('pic1_link')->nullable();
            $table->string('pic2_link')->nullable();
            $table->string('pic3_link')->nullable();
            $table->string('pic4_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_i_chats');
    }
};
