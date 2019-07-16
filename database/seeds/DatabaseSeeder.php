<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

            $this->call('PermissionsTableSeeder');
            $this->call('RolesTableSeeder');
            $this->call('ConnectRelationshipsSeeder');
            $this->call('ReportStatusTableSeeder');
            $this->call('VulnerabilityTableSeeder');
            $this->call('UsersTableSeeder');
            $this->call('ClientTableSeeder');

        Model::reguard();
    }
}
