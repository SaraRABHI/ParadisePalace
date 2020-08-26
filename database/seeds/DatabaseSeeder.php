<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Laravue\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@laravue.dev',
            'password' => Hash::make('laravue'),
            'role'=>'Admin',
        ]);
        $manager = User::create([
            'name' => 'Manager',
            'email' => 'manager@laravue.dev',
            'password' => Hash::make('laravue'),
            'role'=>'Manager',
        ]);
        $commercial = User::create([
            'name' => 'Commercial',
            'email' => 'commercial@laravue.dev',
            'password' => Hash::make('laravue'),
            'role'=>'Commercial',
        ]);
        $host = User::create([
            'name' => 'Host',
            'email' => 'host@laravue.dev',
            'password' => Hash::make('laravue'),
            'role'=>'Host',
        ]);
        $guest = User::create([
            'name' => 'Guest',
            'email' => 'guest@laravue.dev',
            'password' => Hash::make('laravue'),
            'role'=>'Guest',
        ]);

        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $managerRole = Role::findByName(\App\Laravue\Acl::ROLE_MANAGER);
        $commercialRole = Role::findByName(\App\Laravue\Acl::ROLE_COMMERCIAL);
        $hostRole = Role::findByName(\App\Laravue\Acl::ROLE_HOST);
        $guestRole = Role::findByName(\App\Laravue\Acl::ROLE_GUEST);
        $admin->syncRoles($adminRole);
        $manager->syncRoles($managerRole);
        $commercial->syncRoles($commercialRole);
        $host->syncRoles($hostRole);
        $guest->syncRoles($guestRole);
        $this->call(UsersTableSeeder::class);
    }
}
