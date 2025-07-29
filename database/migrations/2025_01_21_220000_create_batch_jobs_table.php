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
        Schema::create('batch_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['invoice', 'quotation', 'estimate', 'po']);
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedBigInteger('template_id')->nullable();
            $table->enum('status', ['pending', 'ready', 'processing', 'completed', 'failed'])->default('pending');
            $table->string('file_path')->nullable();
            $table->integer('total_documents')->default(0);
            $table->integer('processed_documents')->default(0);
            $table->integer('failed_documents')->default(0);
            $table->json('data')->nullable();
            $table->json('generated_documents')->nullable();
            $table->json('errors')->nullable();
            $table->string('zip_url')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'status']);
            $table->index(['type', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_jobs');
    }
}; 