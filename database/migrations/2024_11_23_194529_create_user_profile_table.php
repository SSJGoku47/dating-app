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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('gender_id')->nullable();
            $table->unsignedBigInteger('match_gender_preference_id')->nullable();
            $table->unsignedBigInteger('ethnicity_id')->nullable();
            $table->unsignedBigInteger('education_qualifications_id')->nullable();
            $table->longText('about')->nullable();
            $table->string('religion')->nullable();
            $table->longText('occupation')->nullable();
            $table->integer('age')->nullable();
            $table->decimal('height')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ethnicity_id')->references('id')->on('ethnicities')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->foreign('match_gender_preference_id')->references('id')->on('genders')->onDelete('cascade');
            $table->foreign('education_qualifications_id')->references('id')->on('education_qualifications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
