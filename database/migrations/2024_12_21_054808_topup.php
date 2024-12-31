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
        Schema::create('topup', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('id_transaksi', 150)->default('');
            $table->bigInteger('nominal')->default(0);
            $table->longText('snaptoken')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('status_label', 250)->default('Pending');
            $table->json('data_pay')->default('[]');
            $table->string('payment', 150)->default('Tidak Diketahui');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topup');
    }
};
