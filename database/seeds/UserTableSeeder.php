<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Cristian',
            'apellido' => 'Alvarez',
            'direccion' => 'Cr 67 # 98 a-5',
            'celular' => '3175341811',
            'fecha_naci' => '07/01/1990',
            'cedula' => '123',
            'nit' => '147',
            'telefono' => '789456123',
            'email' => 'admin@random.com',
            'password' => bcrypt('secret')
        ]);
    }
}
