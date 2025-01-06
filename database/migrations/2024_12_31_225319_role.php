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
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->string('label', 250)->nullable();
            $table->timestamps();
        });
 
        // Insert default roles
        DB::table('role')->insert([
            [
                'name' => 'superadmin',
                'label' => 'Super Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'admin',
                'label' => 'Admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'user',
                'label' => 'User',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role');
    }
};
