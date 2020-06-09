<?php

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Set constrains check DOWN
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        // ROLES TABLE
        // Clear roles table
        DB::table('roles')->truncate();
        // Set roles base data and insert
        $roles = [
            ['role'=>'Root','description'=>'Perfil de super administrador de la plataforma'],
            ['role'=>'Administrador','description'=>'Perfil de administrador de la institución'],
            ['role'=>'Maestro','description'=>'Perfil de docente dentro de la institución'],
            ['role'=>'Tutor','description'=>'Perfil de tutor de estudiante dentro de la institución'],
            ['role'=>'Estudiante','description'=>'Perfil de estudiante dentro de la institución'],
        ];

        foreach($roles as $r){DB::table('roles')->insert($r);}


        // USERS TABLE
        // Clear users table
        DB::table('users')->truncate();
        // Set users base data and insert
        $users = [
            ['fk_role' => 1,'name' => "SofTeacher Root",'email' => "root@root.com",'password' => Hash::make('root@root.com')],
            ['fk_role' => 2,'name' => "Institute Admin",'email' => "admin@admin.com",'password' => Hash::make('admin@admin.com')],
            ['fk_role' => 3,'name' => "Institute Teacher",'email' => "teacher@teacher.com",'password' => Hash::make('teacher@ateacher.com')],
            ['fk_role' => 4,'name' => "Institute Parent",'email' => "parent@parent.com",'password' => Hash::make('parent@parent.com')],
            ['fk_role' => 5,'name' => "Institute Student",'email' => "student@student.com",'password' => Hash::make('student@student.com')],
        ];

        foreach($users as $u){DB::table('users')->insert($u);}
        


        // Set constrains check UP
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
