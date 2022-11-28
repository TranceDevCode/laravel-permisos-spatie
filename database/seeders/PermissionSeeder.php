<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creamos el role en la tabla roles con el nombre Super-Admin
        $superAdminRole = Role::create(['name'=>'Super-Admin']);
        //Creamos el usuario Super-Admin
        $superAdmin = User::factory()->create([
            'name'=>'superadmin',
            'email'=>'superadmin@gmail.com',
            'password'=>bcrypt('password')
        ]);
        //Ahora asignamos un role al usuario SuperAdmin creado recientemente.
        $superAdmin->assignRole($superAdminRole);



        //Creamos el role de Manager
        $managerRole = Role::create(['name'=>'Manager']);
        //Creamos el usuario Manager
        $manager = User::factory()->create([
            'name'=>'manager',
            'email'=>'manager@gmail.com',
            'password'=>bcrypt('password')
        ]);
        //Ahora asignamos un role al usuario Manager creado recientemente.
        $manager->assignRole($managerRole);


        //Creamos el role de Employee
        $employeeRole = Role::create(['name'=>'Employee']);
        //Creamos el Employee
        $employee = User::factory()->create([
            'name'=>'employee',
            'email'=>'employee@gmail.com',
            'password'=>bcrypt('password')
        ]);
        //Ahora asignamos un role al Employee creado recientemente.
        $employee->assignRole($employeeRole);

        //Creamos los permisos que tiene nuestra aplicacion 
        Permission::create(['name'=>'list programs']);
        Permission::create(['name'=>'create programs']);
        Permission::create(['name'=>'show programs']);
        Permission::create(['name'=>'update programs']);
        Permission::create(['name'=>'delete programs']);
        Permission::create(['name'=>'show own programs']);
        Permission::create(['name'=>'update own programs']);
        Permission::create(['name'=>'delete own programs']);
        Permission::create(['name'=>'restore own programs']);

        //Ahora asignamos los permisos que nuestros roles de usuarios creados anteriormente
        $manager->givePermissionTo([
            'list programs','create programs','show programs','update programs','delete programs'
        ]);

        $employee->givePermissionTo([
            'list programs','create programs','show own programs','update own programs','delete own programs','restore own programs'
        ]);
    }
}
