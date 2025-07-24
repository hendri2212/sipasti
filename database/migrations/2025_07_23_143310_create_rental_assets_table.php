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

            // tanggal detail sampai jam (mulai & selesai)
            $table->dateTime('start_at');   // contoh: 2025-07-23 08:00:00
            $table->dateTime('end_at');     // contoh: 2025-07-23 17:00:00

            $table->enum('status', ['waiting', 'process', 'finish', 'cancel'])->default('waiting');

            $table->timestamps();
            $table->softDeletes();

            // index tambahan bila perlu
            $table->index(['start_at', 'end_at']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_assets');
    }
};