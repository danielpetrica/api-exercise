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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('internal_id');
            $table->string("id")->unique();
            // contains the customer object received in  case further data needs to be used in the future
            $table->json("json")->nullable();
            $table->string("email")->nullable();
            $table->datetimes("created");
            $table->json("address")->nullable();
            $table->json("shipping")->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
