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
        Schema::create('users_have_services', function (Blueprint $table) {
            $table->foreignId('user_fk')->constrained(table: 'users', column: 'id');

            $table->unsignedBigInteger('service_fk');
            $table->foreign('service_fk')->references('id')->on('services');

            $table->timestamps();

            $table->primary(['user_fk', 'service_fk']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_have_services');
    }
};
