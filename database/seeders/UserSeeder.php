<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleDppm = Role::create(['name' => 'dppm']);
        $roleKaprodi = Role::create(['name' => 'kaprodi']);
        $roleDosen = Role::create(['name' => 'dosen']);

        $faker = Faker::create('id_ID');

        $userDppm = User::factory()->create([
            'name' => 'Direktur Pembinaan Mahasiswa',
            'email' => 'dppm@example.com',
            'password' => Hash::make('password'),
            'faculties_id' => 1,
            // 'nidn' => $faker->randomDigit(),
            // 'scholar_id' => $faker->randomDigit(),
            // 'scopus_id' => $faker->randomDigit(),
        ]);

        $userKaprodi = User::factory()->create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@example.com',
            'password' => Hash::make('password'),
            'faculties_id' => 2,
            // 'nidn' => $faker->randomDigit(),
            // 'scholar_id' => $faker->randomDigit(),
            // 'scopus_id' => $faker->randomDigit(),
        ]);

        $userDosen = User::factory()->create([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
            'password' => Hash::make('password'),
            'faculties_id' => 3,
            // 'nidn' => $faker->randomDigit(),
            // 'scholar_id' => $faker->randomDigit(),
            // 'scopus_id' => $faker->randomDigit(),
        ]);

        $userDppm->assignRole($roleDppm);
        $userKaprodi->assignRole($roleKaprodi);
        $userDosen->assignRole($roleDosen);
    }
}
