<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'name' => "superadmin",
            'email' => "superadmin@gmail.com",
            'password' => Hash::make('password'),
            'phone' => "0812345678910",
            'address' => "Jl. Ikan Cupang Blok X"
        ]);

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'role' => [
                'role-index',
                'role-store',
                'role-update',
                'role-destroy',
            ],
            'user' => [
                'user-index',
                'user-store',
                'user-update',
                'user-destroy',
            ],
            'transaction' => [
                'transaction-index',
                'transaction-store',
                'transaction-update',
                'transaction-destroy',
            ],
            'membership' => [
                'membership-index',
                'membership-store',
                'membership-update',
                'membership-destroy',
            ],
        ];

        foreach ($permissions as $k => $v) {
            foreach ($v as $key => $value) {
                $arr = [];
                $arr['name'] = $value;
                $arr['guard_name'] = 'web';
                Permission::create($arr);
            }
        }

        $superadmin_role = Role::create(['name' => 'Superadmin'])->givePermissionTo([
            $permissions
        ]);
        $superadmin = $superadmin->fresh();
        $superadmin->syncRoles(['superadmin']);

        Role::create(['name' => 'User']);
    }
}
