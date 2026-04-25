<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        DB::table('users')->insertOrIgnore([
            'name'       => 'Admin',
            'email'      => 'admin@salon.com',
            'password'   => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sample services
        $services = [
            ['name' => 'Manicure',       'price' => 150.00, 'duration' => '30 mins',  'description' => 'Basic nail cleaning, shaping, and polishing.'],
            ['name' => 'Pedicure',       'price' => 200.00, 'duration' => '45 mins',  'description' => 'Foot soak, exfoliation, and nail care.'],
            ['name' => 'Gel Polish',     'price' => 300.00, 'duration' => '1 hour',   'description' => 'Long-lasting gel nail polish application.'],
            ['name' => 'Nail Extension', 'price' => 500.00, 'duration' => '2 hours',  'description' => 'Acrylic or gel nail extension sets.'],
            ['name' => 'Nail Art',       'price' => 250.00, 'duration' => '1 hour',   'description' => 'Custom nail art designs.'],
            ['name' => 'Mani-Pedi Combo','price' => 350.00, 'duration' => '1.5 hours','description' => 'Full manicure and pedicure combo package.'],
        ];

        foreach ($services as $s) {
            DB::table('services')->insertOrIgnore(array_merge($s, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
