<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('luthfi_categories', function (Blueprint $table) {
            $table->id();
            // user_id bisa null untuk kategori global (default)
            $table->foreignId('user_id')->nullable()->constrained('luthfi_users')->onDelete('cascade');
            $table->string('name');
            $table->string('type')->comment('income or expense');
            $table->string('icon')->nullable(); // For FontAwesome class
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('luthfi_categories'); }
}; 