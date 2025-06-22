<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('luthfi_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('luthfi_users')->onDelete('cascade');
            $table->string('name');
            $table->string('type')->comment('e.g., Bank, E-Wallet, Cash');
            $table->decimal('balance', 15, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('luthfi_accounts'); }
}; 