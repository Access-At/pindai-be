<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kaprodi;
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
        $roleKuangan =  Role::create(['name' => 'keuangan']);

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

        $userDosen = User::factory()->create([
            'name' => 'Dosen',
            'email' => 'dosen@example.com',
            'password' => Hash::make('password'),
        ]);

        $userDosen1 = User::factory()->create([
            'name' => 'Dosen1',
            'email' => 'dosen1@example.com',
            'password' => Hash::make('password'),
        ]);

        $userKuangan = User::factory()->create([
            'name' => 'Keuangan',
            'email' => 'keuangan@example.com',
            'password' => Hash::make('password'),
        ]);

        Kaprodi::create([
            'user_id' => $userKaprodi->id,
            'faculties_id' => 2,
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
            'is_approved' => 1,
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
        $userKuangan->assignRole($roleKuangan);
    }
}
