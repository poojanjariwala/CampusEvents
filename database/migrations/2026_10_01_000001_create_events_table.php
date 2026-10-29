<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title', 120);
            $table->string('category', 30);
            $table->dateTime('starts_at')->index();
            $table->string('venue', 120);
            $table->string('organizer', 120);
            $table->text('description');
            $table->unsignedInteger('capacity')->default(100);
            $table->unsignedInteger('fee')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
