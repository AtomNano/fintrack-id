<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('luthfi_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('luthfi_users')->onDelete('cascade');
            $table->foreignId('account_id')->constrained('luthfi_accounts')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('luthfi_categories')->onDelete('cascade');
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['income', 'expense']);
            $table->text('description')->nullable();
            $table->date('transaction_date');
            $table->softDeletes(); // For soft delete functionality
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('luthfi_transactions'); }
}; 