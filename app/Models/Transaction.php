<?php
// app/Models/Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'amount',
        'type', // 'income' or 'expense'
        'description',
        'transaction_date',
    ];
    
    protected $casts = [
        'transaction_date' => 'date',
    ];

    // Relasi: Transaksi dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Transaksi dimiliki oleh Account
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    // Relasi: Transaksi dimiliki oleh Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
} 