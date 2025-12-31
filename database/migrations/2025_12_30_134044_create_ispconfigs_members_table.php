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
        Schema::create('ispconfigs_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('NO ACTION');
            $table->string('ispconfig_client_id')->nullable();
            $table->string('ispconfig_service_user_id')->nullable();
            $table->string('email')->nullable();
            $table->enum('type', ['mail', 'web', 'other']);
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ispconfigs_members');
    }
};
