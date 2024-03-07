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
        Schema::create('saved', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('eventName');
            $table->string('eventLocation');
            $table->string('eventDate');
            $table->string('eventImage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved');
    }
};
