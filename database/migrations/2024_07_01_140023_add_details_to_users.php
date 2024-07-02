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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('uuid')->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_admin')->default(false);
            $table->string('avatar')->nullable();
            $table->string('address');
            $table->string('phone_number');
            $table->boolean('is_marketing')->default(false);
            $table->timestamp('last_login_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'uuid',
                'first_name',
                'last_name',
                'is_admin',
                'avatar',
                'address',
                'phone_number',
                'is_marketing',
                'last_login_at',
            ]);

            $table->string('name');
        });
    }
};
