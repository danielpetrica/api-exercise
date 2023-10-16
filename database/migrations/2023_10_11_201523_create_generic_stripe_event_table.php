<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * I'll save them here for now until we handle the other events.
     */
    public function up(): void
    {
        Schema::create('generic_stripe_event', function (Blueprint $table) {
            $table->id('internal_id');
            $table->string("id")->unique();
            $table->string("type");
            // contains the customer object received in case further data needs to be used in the future
            $table->json("json")->nullable();
            $table->datetime("created");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generic_stripe_job');
    }
};
