<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(DepartamentosTableSeeder::class);
        $this->call(MunicipiosTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(TipoagendaTableSeeder::class);
        $this->call(EspecialidadesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PermissionsTableSeedeer::class);
        $this->call(RolesTableSeedeer::class);
        $this->call(SedeTableSeeder::class);
        $this->call(ConsultorioTableSeeder::class);
    }
}
