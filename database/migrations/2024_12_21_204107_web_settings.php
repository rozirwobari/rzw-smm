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
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->mediumText('name')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->integer('gain')->default(1);
            $table->mediumText('logo')->nullable();
            $table->mediumText('favicon')->nullable();
            $table->timestamps();
        });

        DB::table('website_settings')->insert([
            'name' => 'RZW Panel SMM',
            'deskripsi' => 'RZW Panel SMM Terbaik Dan Termurah',

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_settings');
    }
};
