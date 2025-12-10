<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sitemap_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name_th');
            $table->string('name_en')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('sitemaps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sitemap_category_id')->constrained()->onDelete('cascade');
            $table->string('title_th');
            $table->string('title_en')->nullable();
            $table->string('link');
            $table->integer('order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitemaps');
        Schema::dropIfExists('sitemap_categories');
    }
};
