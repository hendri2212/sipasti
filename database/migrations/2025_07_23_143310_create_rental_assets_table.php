<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('institution_id')->constrained('institutions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('asset_id')->constrained('assets')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('photo')->nullable();
            $table->string('letter_number')->nullable();
            $table->date('letter_date')->nullable();
            $table->date('incoming_letter_date')->nullable(); // Tanggal surat masuk
            $table->boolean('recommendation')->default(false); // Checklist perlu rekomendasi
            $table->string('recommendation_letter')->nullable(); // File scan surat rekomendasi
            $table->text('regarding')->nullable(); // Perihal
            $table->enum('status', ['waiting', 'process', 'finish', 'cancel'])->default('waiting');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_assets');
    }
};