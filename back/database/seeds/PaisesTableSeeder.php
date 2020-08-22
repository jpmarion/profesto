<?php

use Illuminate\Database\Seeder;
use App\Pais;

class PaisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('paises')->delete();
        $json = File::get("database/datos/paises.json");
        $data = json_decode($json);
        foreach ($data as $obj) {
            Pais::create(array(
                'id' => $obj->id,
                'nombre' => $obj->nombre
            ));
        }
    }
}
