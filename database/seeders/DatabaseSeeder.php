<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        if (!User::where('email', 'leehongjie91@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'leehongjie91@gmail.com',
                'password' => 'steph432!',
            ]);
        }

        $this->call([
            SiteSettingsSeeder::class,
        ]);
    }
}
