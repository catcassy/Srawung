<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Tabel check-in lokasi user (online/nearby)
        Schema::create('user_checkins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('area_label', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at');
            $table->timestamps();
        });

        // Tabel request ketemu
        Schema::create('meetup_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('target_id')->constrained('users')->cascadeOnDelete();
            $table->string('message', 200)->nullable();
            $table->string('place_suggestion', 200)->nullable();
            $table->enum('status', ['pending','accepted','declined'])->default('pending');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('meetup_requests');
        Schema::dropIfExists('user_checkins');
    }
};
