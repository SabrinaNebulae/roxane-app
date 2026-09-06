<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_renewal_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->year('renewal_year');

            $table->boolean('reminder_1_sent')->default(false);
            $table->boolean('reminder_2_sent')->default(false);
            $table->boolean('reminder_3_sent')->default(false);
            $table->boolean('deactivation_sent')->default(false);

            $table->timestamp('reminder_1_sent_at')->nullable();
            $table->timestamp('reminder_2_sent_at')->nullable();
            $table->timestamp('reminder_3_sent_at')->nullable();
            $table->timestamp('deactivated_at')->nullable();

            $table->timestamps();

            $table->unique(['member_id', 'renewal_year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_renewal_reminders');
    }
};
