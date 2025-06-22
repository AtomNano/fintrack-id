<?php
// app/Models/Account.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type', // e.g., 'E-Wallet', 'Bank', 'Cash'
        'balance',
    ];

    protected $table = 'luthfi_accounts';

    // Relasi: Akun dimiliki oleh User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Akun memiliki banyak Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
} 