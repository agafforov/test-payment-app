<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Andrew Jones',
            'email' => 'andrew_jones@example.com',
        ]);
        User::factory()->create([
            'name' => 'Andrew Jones Junior',
            'email' => 'andrew_jones_junior@example.com',
        ]);
    }
}
