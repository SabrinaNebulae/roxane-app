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
        Schema::table('members', function (Blueprint $table) {
            $table->string('ispconfig_mail_client_id')->after('dolibarr_id')->nullable();
            $table->string('ispconfig_web_client_id')->after('ispconfig_mail_client_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('ispconfig_mail_client_id');
            $table->dropColumn('ispconfig_web_client_id');
        });
    }
};
