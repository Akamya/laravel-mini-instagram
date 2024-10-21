<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // On crée un admin
        User::factory()->create([
            'username' => 'AdminUser',
            'email' => 'admin@example.com',
            'role_id' => 1,
        ]);

        // On crée notre utilisateur de test qui sera maintenant un utilisateur lambda
        User::factory()->create([
            'username' => 'UserUser',
            'email' => 'test@example.com',
            'role_id' => 2,
        ]);

        // 10 utilisateurs lambda
        User::factory(10)->create([
            'role_id' => 2,
        ]);
    }
}
