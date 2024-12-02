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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string("course_name");
            $table->longText("course_info");
            $table->integer("price");
            $table->longText("course_description");
            $table->json("can_learn");
            $table->json("skill_gain");
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("level_id");
            $table->unsignedBigInteger("language_id");
            $table->unsignedBigInteger("instructor_id");
            $table->longText("course_image");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
