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
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Primary key for the message
            $table->unsignedBigInteger('sender_id'); // The ID of the user sending the message
            $table->unsignedBigInteger('recipient_id'); // The ID of the user receiving the message (admin or specific user)
            $table->text('message'); // The actual message content
            $table->timestamps(); // Timestamps for when the message was created/sent

            // Define foreign key relationships with the 'users' table
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('recipient_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
