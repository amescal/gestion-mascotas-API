<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MascotaAMC;

class AMCSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //si el usuario no existe se crea en la base de datos, usamos el email que es un campo unique
        if(User::where('email', 'AMC1@email.AMC')->count()==0)
        {
            $amc1= new User;
            $amc1->name='AMC1';
            $amc1->email='AMC1@email.AMC';
            //establecemos el email como verificado
            $amc1->email_verified_at=now();
            $amc1->password=Hash::make('AMC1');
            //Almacenamos el usuario en la base de datos
            $amc1->save();

            //Usamos el id del usuario que hemos guardado para vincularlo a sus mascotas
            //no hay ningún campo de las mascotas que sea unique en la base de datos, se pueden repetir todos los datos rellenables
            $amc1_mascota1= new MascotaAMC;
            $amc1_mascota1->user_id=$amc1->id;
            $amc1_mascota1->nombre='Pelusa';
            $amc1_mascota1->descripcion='Gatete peludo';
            $amc1_mascota1->tipo='Gato';
            $amc1_mascota1->publica='Si';
            //$amc1_mascota1->megusta no lo ponemos así ya empieza por defecto en cero
            $amc1_mascota1->save();

            $amc1_mascota2= new MascotaAMC;
            $amc1_mascota2->user_id=$amc1->id;
            $amc1_mascota2->nombre='Curri';
            $amc1_mascota2->descripcion='Perrito blanco';
            $amc1_mascota2->tipo='Perro';
            $amc1_mascota2->publica='No';
            //$amc1_mascota2->megusta no lo ponemos así ya empieza por defecto en cero
            $amc1_mascota2->save();

            $amc1_mascota3= new MascotaAMC;
            $amc1_mascota3->user_id=$amc1->id;
            $amc1_mascota3->nombre='Nagini';
            $amc1_mascota3->descripcion='sssssss';
            $amc1_mascota3->tipo='Serpiente';
            $amc1_mascota3->publica='Si';
            //$amc1_mascota3->megusta no lo ponemos así ya empieza por defecto en cero
            $amc1_mascota3->save();
        }

        //Insertamos un segundo usuario si no existe en la base de datos
        if(User::where('email', 'AMC2@email.AMC')->count()==0)
        {
            $amc2= new User;
            $amc2->name='AMC2';
            $amc2->email='AMC2@email.AMC';
            //establecemos el email como verificado
            $amc2->email_verified_at=now();
            $amc2->password=Hash::make('AMC2');
            //Almacenamos el usuario en la base de datos
            $amc2->save();

            //Usamos el id del usuario que hemos guardado para vincularlo a sus mascotas
            //no hay ningún campo de las mascotas que sea unique en la base de datos, se pueden repetir todos los datos rellenables
            $amc2_mascota1= new MascotaAMC;
            $amc2_mascota1->user_id=$amc2->id;
            $amc2_mascota1->nombre='Bolita';
            $amc2_mascota1->descripcion='Gato naranjoso';
            $amc2_mascota1->tipo='Gato';
            $amc2_mascota1->publica='No';
            //$amc2_mascota1->megusta no lo ponemos así ya empieza por defecto en cero
            $amc2_mascota1->save();

            $amc2_mascota2= new MascotaAMC;
            $amc2_mascota2->user_id=$amc2->id;
            $amc2_mascota2->nombre='Patxi';
            $amc2_mascota2->descripcion='Pájaro cantor';
            $amc2_mascota2->tipo='Pajaro';
            $amc2_mascota2->publica='Si';
            //$amc2_mascota2->megusta no lo ponemos así ya empieza por defecto en cero
            $amc2_mascota2->save();

            $amc2_mascota3= new MascotaAMC;
            $amc2_mascota3->user_id=$amc2->id;
            $amc2_mascota3->nombre='Fanta';
            $amc2_mascota3->descripcion='Blanco y amoroso';
            $amc2_mascota3->tipo='Conejo';
            $amc2_mascota3->publica='Si';
            //$amc2_mascota3->megusta no lo ponemos así ya empieza por defecto en cero
            $amc2_mascota3->save();
        }
    }
}
