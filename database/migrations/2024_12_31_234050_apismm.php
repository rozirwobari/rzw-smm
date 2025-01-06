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
        Schema::create('apismm', function (Blueprint $table) {
            $table->id();
            $table->longText('name')->nullable();
            $table->longText('api_key')->nullable();
            $table->longText('secret_key')->nullable();
            $table->integer('convert')->default(1);
            $table->longText('host')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apismm');
    }
};
