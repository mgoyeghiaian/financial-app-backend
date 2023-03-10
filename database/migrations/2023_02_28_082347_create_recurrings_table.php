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
        Schema::create('recurrings', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('category');
            // $table->boolean('isDeleted');
            $table->string('title');
            $table->decimal('amount');
            $table->date('startDate');
            $table->date('endDate');
            // $table->unsignedBigInteger('admin_id')->uniqid();
            // $table->foreign('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurrings');
    }
};
