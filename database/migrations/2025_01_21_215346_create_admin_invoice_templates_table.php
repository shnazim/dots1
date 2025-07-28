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
        Schema::create('admin_invoice_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('body');
            $table->longText('editor');
            $table->text('custom_css')->nullable();
            $table->string('type', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_invoice_templates');
    }
};
