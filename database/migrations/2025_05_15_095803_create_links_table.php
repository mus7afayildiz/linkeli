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
        Schema::create('links', function (Blueprint $table) {
            $table->id('link_id');
            $table->text('source_link');
            $table->string('shortcut_link')->unique();
            $table->boolean('password_protected')->default(false);
            $table->string('password_hash')->nullable();
            $table->unsignedBigInteger('user_fk');
            $table->bigInteger('counter')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->foreign('user_fk')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
