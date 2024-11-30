<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('dob')->nullable()->after('phone');
            $table->unsignedBigInteger('role_id')->after('name');
            $table->boolean('is_active')->nullable()->after('role_id')->default('true');
            $table->boolean('is_admin')->nullable()->after('is_active')->default('false');
            $table->timestamp('last_active_at')->nullable()->after('password');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->softDeletes();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
