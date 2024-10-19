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
        Schema::create('incident', function (Blueprint $table) {
            $table->id();
            $table->foreignId( 'ref_user' )->constrained(
                'user', 'id'
            );
            $table->integer( 'ref_vendor_id' )->nullable();
            $table->foreignId( 'ref_category' )->constrained(
                'category', 'id'
            );
            $table->text( 'latitude' );
            $table->text( 'longitude' );
            $table->text( 'value' );
            $table->boolean( 'is_active' )->default( true );
            $table->timestamp( 'dt_register' )->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident');
    }
};
