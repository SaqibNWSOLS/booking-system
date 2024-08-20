<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('services_id')->nullable()->constrained('services')->onDelete('no action')->onUpdate('no action');
            $table->foreignId('users_id')->nullable()->constrained('users')->onDelete('no action')->onUpdate('no action');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('no action')->onUpdate('no action');
            $table->string('status', 256)->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('no action')->onUpdate('no action');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
