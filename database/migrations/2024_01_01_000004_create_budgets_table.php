<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('luthfi_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('luthfi_users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('luthfi_categories')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->unsignedSmallInteger('month');
            $table->unsignedSmallInteger('year');
            $table->timestamps();

            // Budget harus unik untuk user, kategori, bulan, dan tahun yang sama
            $table->unique(['user_id', 'category_id', 'month', 'year']);
        });
    }
    public function down(): void { Schema::dropIfExists('luthfi_budgets'); }
}; 