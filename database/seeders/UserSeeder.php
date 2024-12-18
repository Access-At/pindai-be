<?php

namespace Database\Seeders;

use App\Models\Dosen;
use App\Models\Kaprodi;
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


        $userDppm = User::factory()->create([
            'name' => 'Direktur Pembinaan Mahasiswa',
            'email' => 'dppm@example.com',
            'password' => Hash::make('password'),
        ]);

        $userKaprodi = User::factory()->create([
            'name' => 'Kaprodi',
            'email' => 'kaprodi@example.com',
            'password' => Hash::make('password'),
        ]);

        Kaprodi::create([
            'user_id' => $userKaprodi->id,
            'faculties_id' => 2,
        ]);

        $userDosen = User::factory()->create([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
            'password' => Hash::make('password'),
        ]);

        Dosen::create([
            'user_id' => $userDosen->id,
            'name_with_title' => "Dr. {$userDosen->name} S.pd M.pd A.pd",
            'phone_number' => '081234567890',
            'scholar_id' => '1234567890',
            'scopus_id' => '1234567890',
            'job_functional' => 'Dosen',
            'affiliate_campus' => 'Kampus A',
            'prodi_id' => 1,
        ]);

        $userDosen1 = User::factory()->create([
            'name' => 'Dosen1',
            'email' => 'dosen1@example.com',
            'password' => Hash::make('password'),
        ]);

        Dosen::create([
            'user_id' => $userDosen1->id,
            'name_with_title' => "Dr. {$userDosen1->name} S.pd M.pd A.pd",
            'phone_number' => '081234567890',
            'scholar_id' => '1234567891',
            'scopus_id' => '1234567891',
            'job_functional' => 'Dosen',
            'affiliate_campus' => 'Kampus A',
            'prodi_id' => 2,
        ]);

        $userDppm->assignRole($roleDppm);
        $userKaprodi->assignRole($roleKaprodi);
        $userDosen->assignRole($roleDosen);
        $userDosen1->assignRole($roleDosen);
    }
}
