<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Roles;
use App\Models\User;
use App\Models\TypeOfService;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Buat roles
        $admin = Roles::create(['roles_name' => 'Admin']);
        $operator = Roles::create(['roles_name' => 'Operator']);
        $pimpinan = Roles::create(['roles_name' => 'Pimpinan']);

        // Buat user default
        User::create([
            'role_id' => $admin->id,
            'name' => 'Super Admin',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'role_id' => $operator->id,
            'name' => 'Operator 1',
            'email' => 'operator@laundry.com',
            'password' => Hash::make('operator123'),
        ]);

        User::create([
            'role_id' => $pimpinan->id,
            'name' => 'Pimpinan',
            'email' => 'pimpinan@laundry.com',
            'password' => Hash::make('pimpinan123'),
        ]);

        // Buat 4 jenis service sesuai soal
        TypeOfService::insert([
            ['service_name' => 'Cuci dan Gosok', 'price' => 5000, 'description' => 'Cuci dan gosok per kg', 'created_at' => now(), 'updated_at' => now()],
            ['service_name' => 'Hanya Cuci', 'price' => 4500, 'description' => 'Hanya cuci per kg', 'created_at' => now(), 'updated_at' => now()],
            ['service_name' => 'Hanya Gosok', 'price' => 5000, 'description' => 'Hanya gosok per kg', 'created_at' => now(), 'updated_at' => now()],
            ['service_name' => 'Laundry Besar', 'price' => 7000, 'description' => 'Selimut, karpet, sprei', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}