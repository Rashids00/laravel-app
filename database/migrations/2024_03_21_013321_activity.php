<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('activity', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('add');
            $table->date('date');
            $table->boolean('status')->default(false);
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('activity');
    }
};
