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
        // MEMBERS
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // User
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->string('dolibarr_id')->nullable();

            // Keycloak
            $table->string('keycloak_id')->nullable();

            // Statuses
            $table->enum('status', [
                'draft',
                'valid',
                'pending',
                'cancelled',
                'excluded'
            ])->default('draft');

            // Nature
            $table->enum('nature', ['physical', 'legal'])->default('physical');

            // Type
            $table->unsignedBigInteger('type_id')->nullable();

            // Group
            $table->unsignedBigInteger('group_id')->nullable();

            // Identity
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('email');
            $table->string('retzien_email')->nullable();
            $table->string('company')->nullable();
            $table->date('date_of_birth')->nullable();

            // Coordinates
            $table->string('address')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();

            // Membership type
            $table->boolean('public_membership')->default(false);

            // Others
            $table->string('website_url')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
