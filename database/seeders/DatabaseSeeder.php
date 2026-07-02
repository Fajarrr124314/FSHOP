<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default admin user
        User::updateOrCreate(
            ['email' => 'admin@fshop.space'],
            [
                'name' => 'FSHOP Admin',
                'role' => 'admin',
                'password' => bcrypt('admin123'), // Fallback password for mock login
            ]
        );

        // Seed default customer user
        User::updateOrCreate(
            ['email' => 'customer@fshop.space'],
            [
                'name' => 'FSHOP Customer',
                'role' => 'customer',
                'password' => bcrypt('customer123'),
            ]
        );

        $this->call(ShopCatalogSeeder::class);
    }
}
