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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string("name", 100)->unique();
            $table->string("author");
            $table->text("image_path")->nullable();
            $table->text("description")->nullable();
            $table->enum("status", ["Published", "Draft", "Archived"])->default("Draft");

            // FTS: Full-text-search index
            // hopefully mysql can do enough relative to postgres on this feature
            $table->fullText(["name", "author"], "books_fts_index");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
