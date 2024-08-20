<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->nullable()->constrained('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('title', 256)->nullable();
            $table->string('slug', 256)->nullable();
            $table->decimal('price', 11, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('email', 256)->nullable();
            $table->string('contact_name', 256)->nullable();
            $table->string('contact_number', 256)->nullable();
            $table->string('address', 256)->nullable();
            $table->decimal('latitude', 11, 2)->nullable();
            $table->decimal('longitude', 11, 2)->nullable();
            $table->enum('status', ['Active', 'In-Active'])->default('Active');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('no action')->onUpdate('no action');
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
        Schema::dropIfExists('services');
    }
};
