<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('content');
            $table->string('cover_photo')->nullable();
            $table->string('format')->default('general');
            $table->string('priority')->default('normal');
            $table->json('audience')->default('"all"');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_public')->default(false);
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('archived_by')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->string('archive_reason')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('archived_by')->references('id')->on('users')->nullOnDelete();

            $table->index(['is_active', 'publish_at', 'expires_at']);
            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
