<?php

use App\User;
use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRole = Role::where('name', '=', 'User')->first();
        $adminRole = Role::where('name', '=', 'Admin')->first();
        $permissions = Permission::all();

        /*
         * Add Users
         *
         */
        if (User::where('email', '=', 'admin@reporter.xyz')->first() === null) {
            $newUser = User::create([
                'first_name'     => 'Richard',
                'last_name'     => 'Clifford',
                'active'     => 1,
                'email'    => 'admin@reporter.xyz',
                'password' => bcrypt('password'),
            ]);

            DB::table('role_user')->insert([
                'role_id' => 1,
                'user_id' => 1,
            ]);

            // $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }
    }
}
