<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Project\Database\Seeders\ProjectDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Jose Guerrero',
            'email' => 'jose.guerrero.carrizo@gmail.com',
            'password' => Hash::make('123456789')
        ]);

        $this->call([
            ProjectDatabaseSeeder::class,
        ]);
    }
}
