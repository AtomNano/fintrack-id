<?php
// app/Models/Category.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'luthfi_categories';

    protected $fillable = [
        'user_id', // Nullable for global categories
        'name',
        'type', // 'income' or 'expense'
        'icon', // FontAwesome icon class
    ];

    // Relasi: Kategori bisa dimiliki oleh User (untuk kategori custom)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Kategori memiliki banyak Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi: Kategori memiliki banyak Budget
    public function budgets()
    {
        return $this->hasMany(Budget::class);
    }
} 