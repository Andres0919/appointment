<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name' => 'Medicina General',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicos Experto Salud Mental',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicos Experto Reumatologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicos Experto Anticoagulados',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicos Experto Nefroproteccion',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicos Experto Respiratorios',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicos Experto Trasmisibles Cronicas',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Psiquiatria',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Neurologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Cardiologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Ginecologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Obstetricia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicina Interna',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Anestesiologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicina Familiar',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Hematologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Nefrologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Otorrinolaringologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Oftalmologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Ortopedia y Traumatologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Endocrinologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Cirugia Coloproctologica',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Cirugia General',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Pediatria',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Dermatologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicina del Deporte',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Alergologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Mastologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Neumologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Medicina del Dolo',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Oncologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Toxicologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Fisiatria',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Urologia'
,            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => ' Medicina Alternativa',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Neurocirugia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Infectologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Reumatologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Electrofisiologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Fonoaudiologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Terapia Respiratoria',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Fisioterapia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Trabajo Social',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Psicologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Nutricion',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Optometria',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Odontologia ',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Especialidades de Odontologia',
            'guard_name' => 'api'
        ]);
        $role = Role::create([
            'name' => 'Enfermeria',
            'guard_name' => 'api'
        ]);
        $role->givePermissionTo('medico');
    }
}
