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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('title');
            $table->text('content');
            $table->foreignId('category_id')->constrained('categories');
            $table->string('image')->nullable();
            $table->integer('views')->default(0);
            $table->enum('status', ['active', 'locked', 'deleted']);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sontanav2', function (Blueprint $table) {
            //
            $table->dropColumn('image');
        });
    }
};
