<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kosongkan tabel dulu jika perlu
        // DB::table('categories')->truncate();

        $categories = [
            // Kategori Pemasukan
            ['name' => 'Gaji', 'type' => 'income', 'icon' => 'fa-solid fa-wallet'],
            ['name' => 'Bonus', 'type' => 'income', 'icon' => 'fa-solid fa-hand-holding-dollar'],
            ['name' => 'Investasi', 'type' => 'income', 'icon' => 'fa-solid fa-arrow-trend-up'],
            ['name' => 'Lainnya', 'type' => 'income', 'icon' => 'fa-solid fa-ellipsis'],

            // Kategori Pengeluaran
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'icon' => 'fa-solid fa-utensils'],
            ['name' => 'Transportasi', 'type' => 'expense', 'icon' => 'fa-solid fa-car'],
            ['name' => 'Tagihan', 'type' => 'expense', 'icon' => 'fa-solid fa-file-invoice-dollar'],
            ['name' => 'Belanja', 'type' => 'expense', 'icon' => 'fa-solid fa-cart-shopping'],
            ['name' => 'Hiburan', 'type' => 'expense', 'icon' => 'fa-solid fa-film'],
            ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => 'fa-solid fa-notes-medical'],
            ['name' => 'Pendidikan', 'type' => 'expense', 'icon' => 'fa-solid fa-graduation-cap'],
            ['name' => 'Keluarga', 'type' => 'expense', 'icon' => 'fa-solid fa-people-roof'],
            ['name' => 'Lainnya', 'type' => 'expense', 'icon' => 'fa-solid fa-ellipsis'],
        ];

        foreach ($categories as $category) {
            Category::create([
                'user_id' => null, // Kategori global tidak punya user_id
                'name' => $category['name'],
                'type' => $category['type'],
                'icon' => $category['icon'],
            ]);
        }
    }
} 