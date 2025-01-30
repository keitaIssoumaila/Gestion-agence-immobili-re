<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'keitaissmi@gmail.com'],
            [
                'name' => 'Soumaila',
                'password' => Hash::make('infoma1*'),
                'role' => 'super_admin',
                'photo' => 'images/default-avatar.png',
                'agence_id' => null, // Assurez-vous que ce champ est nullable
            ]
        );
    }
}
