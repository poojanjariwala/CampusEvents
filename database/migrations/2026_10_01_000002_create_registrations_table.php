<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name', 60);
            $table->string('email', 100);
            $table->string('enrollment', 15);
            $table->string('phone', 10);
            $table->string('class_name', 30);
            $table->timestamps();

            // one seat per person per event
            $table->unique(['event_id', 'email']);
            $table->unique(['event_id', 'enrollment']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
