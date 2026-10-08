<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_posts', function (Blueprint $table) {
            $table->id();
            // image | video — video is supported by the schema, but only verified
            // media ships, so every seeded post is an image carousel.
            $table->string('kind', 16)->default('image');
            $table->text('caption');
            $table->string('place')->nullable();
            $table->string('badge')->nullable();
            $table->string('badge_tone')->nullable();
            $table->boolean('is_placeholder')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_posts');
    }
};
