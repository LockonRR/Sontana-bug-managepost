<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reporter_id')->constrained('users');
            $table->foreignId('post_id')->nullable()->constrained('posts');
            $table->foreignId('comment_id')->nullable()->constrained('comments');
            $table->text('reason');
            $table->enum('status', ['pending', 'reviewed', 'dismissed']);
            $table->timestamps();
        });
    }
    

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
