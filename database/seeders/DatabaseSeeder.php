<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\MenusSeeder;
use Database\Seeders\RoleHasMenuPermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            KecamatanSeeder::class,
            KelurahanSeeder::class,
            MenusSeeder::class,
            RoleHasMenuPermissionsSeeder::class,
            RolePermissionSeeder::class,
            UserSeeder::class,
        ]);

    
    }
}
