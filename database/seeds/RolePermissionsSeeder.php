<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\User;
use App\Models\Role;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


      $permissions = Permission::defaultPermissions();

      foreach ($permissions as $perms) {
          Permission::firstOrCreate(['name' => $perms]);
      }

      $this->command->info('Default Permissions added.');
      $role = Role::where('name','SuperAdmin')->first();

      $role->syncPermissions(Permission::all());
      $this->command->info('SuperAdmin granted all the permissions');


    }
}
