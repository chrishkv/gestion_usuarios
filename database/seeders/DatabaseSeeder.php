<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(array('name' => 'Admin'));
        $roleNormal = Role::create(array('name' => 'Normal'));
        $permissionEdit = Permission::create(array('name' => 'edit'));
        $permissionDelete = Permission::create(array('name' => 'delete'));
        $permissionChange = Permission::create(array('name' => 'change_role'));
        $permissionEdit->syncRoles(array($roleAdmin, $roleNormal));
        $permissionDelete->assignRole($roleAdmin);
        $permissionChange->assignRole($roleAdmin);

        User::create(array(
            'name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')))
            ->assignRole($roleAdmin);

        $usuarios = User::factory(20)
                    ->sequence(fn ($sequence) => ['last_name' => $sequence->index + 2] )
                    ->create();
        $usuarios->map(function ($usuario) use ($roleNormal) {$usuario->assignRole($roleNormal);});
    }
}
