<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // disable fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");

            // enable back fk constrain check
            // \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Seed the default permissions
            $permissions = Permission::defaultPermissions();

            foreach ($permissions as $perms) {
                Permission::firstOrCreate(['name' => $perms]);
            }

            $this->command->info('Default Permissions added.');

    

                // Ask for roles from input
                $input_roles = 'SuperAdmin,Dispensary Admin,Consumer';

                // Explode roles
                $roles_array = explode(',', $input_roles);

                // add roles
                foreach($roles_array as $role) {
                    $role = Role::firstOrCreate(['name' => trim($role)]);

                    if( $role->name == 'SuperAdmin' ) {
                        // assign all permissions
                        $role->syncPermissions(Permission::all());
                        $this->command->info('SuperAdmin granted all the permissions');
                    }
                    else {
                        // for others by default only read access
                        $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                    }

                    // create one user for each role
                    $this->createUser($role);
                }

                $this->command->info('Roles ' . $input_roles . ' added successfully');



            $this->command->info('Data seeded');
            $this->command->warn('All done :)');
        }

    }



    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($role)
    {
        if( $role->name == 'SuperAdmin' ) {

            $user = User::create([
                'name' => 'SuperAdmin',
                'email' => 'superadmin@blockspot.io',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10)
            ]);
            
            $user->assignRole($role->name);

            $this->command->info('Here is your superadmin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "secret"');
        }
        else if( $role->name == 'Admin' ) {

            $user = User::create([
                'name' => 'Admin',
                'email' => 'admin@blockspot.io',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10)
            ]);
            
            $user->assignRole($role->name);
        }

        else if( $role->name == 'User' ) {

            $user = User::create([
                'name' => 'User',
                'email' => 'user@blockspot.io',
                'password' => bcrypt('secret'),
                'remember_token' => str_random(10)
            ]);
            
            $user->assignRole($role->name);
        }
    }
}
