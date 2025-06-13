<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $adminRole = Role::create(['name' => 'Admin']);
        $salesRole = Role::create(['name' => 'Salesperson']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        $salesperson = User::create([
            'name' => 'Salesperson',
            'email' => 'salesperson@example.com',
            'password' => Hash::make('password'),
        ]);

        $admin->roles()->attach($adminRole);
        $salesperson->roles()->attach($salesRole);

        Product::factory(20)->create();
    }
}
