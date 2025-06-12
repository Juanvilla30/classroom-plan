<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Roles
        DB::table('roles')->insert([
            ['id' => 1, 'name_role' => 'administrador'],
            ['id' => 2, 'name_role' => 'vicerrectoría'],
            ['id' => 3, 'name_role' => 'coordinador'],
            ['id' => 4, 'name_role' => 'docente'],
        ]);

        // Facultades
        DB::table('faculties')->insert([
            ['id' => 1, 'code_faculty' => '1', 'name_faculty' => 'facultad de ingeniería y ciencias naturales'],
            ['id' => 2, 'code_faculty' => '2', 'name_faculty' => 'facultad ciencias sociales y humanidades'],
            ['id' => 3, 'code_faculty' => '3', 'name_faculty' => 'facultad ciencias administrativas, contables y económicas'],
        ]);

        // Niveles de Educación
        DB::table('education_levels')->insert([
            ['id' => 1, 'name_education_level' => 'pregrado'],
            ['id' => 2, 'name_education_level' => 'posgrado'],
        ]);

        // Programas
        DB::table('programs')->insert([
            ['id' => 1, 'code_program' => '00001', 'name_program' => 'ingeniería energética', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 1],
            ['id' => 2, 'code_program' => '00001', 'name_program' => 'ingeniería electrónica', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 1],
            ['id' => 3, 'code_program' => '110398', 'name_program' => 'ingeniería de software y computación', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 1],
            ['id' => 4, 'code_program' => '00001', 'name_program' => 'ingeniería civil', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 1],
            ['id' => 5, 'code_program' => '00001', 'name_program' => 'ingeniería ambiental y de saneamiento', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 1],
            ['id' => 6, 'code_program' => '00001', 'name_program' => 'derecho', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 2],
            ['id' => 7, 'code_program' => '00001', 'name_program' => 'licenciatura y educación infantil', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 2],
            ['id' => 8, 'code_program' => '00001', 'name_program' => 'entrenamiento deportivo', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 2],
            ['id' => 9, 'code_program' => '00001', 'name_program' => 'gobierno y relaciones internacionales', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 2],
            ['id' => 10, 'code_program' => '00001', 'name_program' => 'administración de empresas', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 3],
            ['id' => 11, 'code_program' => '00001', 'name_program' => 'finanzas y negocios internacionales', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 3],
            ['id' => 12, 'code_program' => '00001', 'name_program' => 'contaduría publica', 'anio' => '2024', 'id_education_level' => 1, 'degree_type' => 'profesional', 'id_faculty' => 3],
            ['id' => 13, 'code_program' => '00001', 'name_program' => 'especialización en derecho penal', 'anio' => '2024', 'id_education_level' => 2, 'degree_type' => 'profesional', 'id_faculty' => 2],
            ['id' => 14, 'code_program' => '00001', 'name_program' => 'especialización en pedagogía', 'anio' => '2024', 'id_education_level' => 2, 'degree_type' => 'profesional', 'id_faculty' => 2],
            ['id' => 15, 'code_program' => '00001', 'name_program' => 'especialización en promoción y defensa de los derechos humanos', 'anio' => '2024', 'id_education_level' => 2, 'degree_type' => 'profesional', 'id_faculty' => 2],
            ['id' => 16, 'code_program' => '00001', 'name_program' => 'especialización en proyectos de desarrollo', 'anio' => '2024', 'id_education_level' => 2, 'degree_type' => 'profesional', 'id_faculty' => 3],
            ['id' => 17, 'code_program' => '00001', 'name_program' => 'especialización gestión del riesgo', 'anio' => '2024', 'id_education_level' => 2, 'degree_type' => 'profesional', 'id_faculty' => 1],
        ]);

        // Usuarios
        User::create([
            'name' => 'admin',
            'last_name' => 'suport',
            'phone' => '0',
            'email' => 'aulamanager.support@gmail.com',
            'password' => 'admin',
            'id_role' => '1',
        ]); //1

        // VICERRECTOR
        User::create([
            'name' => 'vicerrector',
            'last_name' => 'vice',
            'phone' => '0',
            'email' => 'vicerrectoria@uniautonoma.edu.co',
            'password' => 'vicerrectoria',
            'id_role' => '2',
        ]); //2

        // COORDINADORES
        User::create([
            'name' => 'coordinador',
            'last_name' => 'software',
            'phone' => '0',
            'email' => 'coordinacion.software@uniautonoma.edu.co',
            'password' => 'coordinacion',
            'id_role' => '3',
            'id_program' => '3',
        ]); //3

        User::create([
            'name' => 'coordinador',
            'last_name' => 'energetica',
            'phone' => '0',
            'email' => 'coordinacion.energetica@uniautonoma.edu.co',
            'password' => 'coordinacion',
            'id_role' => '3',
            'id_program' => '1',
        ]); //4

        User::create([
            'name' => 'coordinador',
            'last_name' => 'especialización en derecho penal',
            'phone' => '0',
            'email' => 'coordinacion.especializacion.penal@uniautonoma.edu.co',
            'password' => 'coordinacion',
            'id_role' => '3',
            'id_program' => '13',
        ]); //5

        User::create([
            'name' => 'coordinación',
            'last_name' => 'Derecho',
            'phone' => '0',
            'email' => 'coordinacion.derecho@uniautonoma.edu.co',
            'password' => 'coordinacion',
            'id_role' => '3',
            'id_program' => '6',
        ]); //6

        // DOCENTE
        User::create([
            'name' => 'docente',
            'last_name' => 'campo comun',
            'phone' => '0',
            'email' => 'docente.campo.comun@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => null,
        ]); //7

        User::create([
            'name' => 'Juan Pablo',
            'last_name' => 'Diago Rodriguez',
            'phone' => '0',
            'email' => 'juan.diago.r@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //8

        User::create([
            'name' => 'Zulema Yidney',
            'last_name' => 'León Escobar',
            'phone' => '0',
            'email' => 'zulema.leon.e@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //9

        User::create([
            'name' => 'Carlos Antonio',
            'last_name' => 'Flores Arias',
            'phone' => '0',
            'email' => 'carlos.antonio.f@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //10

        User::create([
            'name' => 'Jose Fernando',
            'last_name' => 'Concha',
            'phone' => '0',
            'email' => 'jose.fernando.c@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //11

        User::create([
            'name' => 'Cristian',
            'last_name' => 'Cañar',
            'phone' => '0',
            'email' => 'cristian.canar@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //12

        User::create([
            'name' => 'Ana María',
            'last_name' => 'Caviedes Castillo',
            'phone' => '0',
            'email' => 'ana.caviedes.c@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //13

        User::create([
            'name' => 'Diego Fernando',
            'last_name' => 'Prado Osorio',
            'phone' => '0',
            'email' => 'diego.prado.o@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //14

        User::create([
            'name' => 'Jose Guerlly',
            'last_name' => 'Lara Anaya',
            'phone' => '0',
            'email' => 'jose.lara.a@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //15

        User::create([
            'name' => 'Ana Gabriela',
            'last_name' => 'Fernandez Morantes',
            'phone' => '0',
            'email' => 'ana.fernandez.m@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //16

        User::create([
            'name' => 'Santiago',
            'last_name' => 'Muñoz de la Rosa',
            'phone' => '0',
            'email' => 'santiago.munoz.r@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //17

        User::create([
            'name' => 'Julián',
            'last_name' => 'Bermúdez',
            'phone' => '0',
            'email' => 'julian.bermudez.d@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //18

        User::create([
            'name' => 'Angela Maria',
            'last_name' => 'Romero Arias',
            'phone' => '0',
            'email' => 'angela.romero.a@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //19

        User::create([
            'name' => 'Victor Hugo',
            'last_name' => 'Ruiz Guachetá',
            'phone' => '0',
            'email' => 'victor.ruiz.g@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //20

        User::create([
            'name' => 'Jose Orlando',
            'last_name' => 'Ante',
            'phone' => '0',
            'email' => 'Jose.orlando.a@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //21

        User::create([
            'name' => 'Oscar Alexander',
            'last_name' => 'Tobar M',
            'phone' => '0',
            'email' => 'oscar.tobar.m@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //22

        User::create([
            'name' => 'Diego',
            'last_name' => 'Vasquez',
            'phone' => '0',
            'email' => 'diego.vasquez.d@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //23

        User::create([
            'name' => 'Nohora Lucia',
            'last_name' => 'Urbano',
            'phone' => '0',
            'email' => 'nohora.lucia.u@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //24

        User::create([
            'name' => 'Natalia',
            'last_name' => 'Reyes',
            'phone' => '0',
            'email' => 'natalia.reyes.d@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //26

        User::create([
            'name' => 'Valentina Arciniegas',
            'last_name' => 'Solarte',
            'phone' => '0',
            'email' => 'valentina.solarte.d@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]); //27

        // DERECHO
        User::create([
            'name' => 'Juan Pablo',
            'last_name' => 'Sterling',
            'phone' => '0',
            'email' => 'juan.sterling.c@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '6',
        ]); //28

        User::create([
            'name' => 'Julián',
            'last_name' => 'Guachetá',
            'phone' => '0',
            'email' => 'julian.guacheta.t@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '6',
        ]); //29

        User::create([
            'name' => 'Esperanza del Carmen',
            'last_name' => 'Reyes',
            'phone' => '0',
            'email' => 'consultoriojuridico@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '6',
        ]); //30

        User::create([
            'name' => 'Matilde Andrea',
            'last_name' => 'López',
            'phone' => '0',
            'email' => 'matilde.lopez.g@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '6',
        ]); //31

        User::create([
            'name' => 'Pablo Cesar',
            'last_name' => 'Guzmán',
            'phone' => '0',
            'email' => 'pablo.guzman.m@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '6',
        ]); //32

        // Atributos usuario
        DB::table('user_attributes')->insert([
            ['id' => 1, 'profession' => 'Ingeniero de sistemas', 'postgraduate_studies' => 'Esp. Ingeniería del software, Esp. Gestión de proyectos, MBA Dirección proyectos', 'specific_competences' => 'Desarrollo de software - Programación modular', 'id_user' => 6],
            ['id' => 2, 'profession' => 'Licenciado', 'postgraduate_studies' => 'Esp. Gestión de proyectos, MBA Dirección proyectos', 'specific_competences' => 'Campo comun', 'id_user' => 9],
            ['id' => 3, 'profession' => 'Especializacion', 'postgraduate_studies' => 'Esp. Gestión de proyectos, MBA Dirección proyectos', 'specific_competences' => 'Posgrago', 'id_user' => 8],
        ]);

        // Modalidades
        DB::table('modalities')->insert([
            ['id' => 1, 'name_modality' => 'presencial'],
            ['id' => 2, 'name_modality' => 'asistida'],
            ['id' => 3, 'name_modality' => 'hibrida'],
            ['id' => 4, 'name_modality' => 'virtual'],
        ]);

        // Campos de Estudio
        DB::table('study_fields')->insert([
            ['id' => 1, 'name_study_field' => 'campo comun'],
            ['id' => 2, 'name_study_field' => 'campo ciencias basicas'],
            ['id' => 3, 'name_study_field' => 'campo disciplinar'],
        ]);

        // Componentes
        DB::table('components')->insert([
            ['id' => 1, 'name_component' => 'emprendimiento', 'id_study_field' => 1],
            ['id' => 2, 'name_component' => 'investigación', 'id_study_field' => 1],
            ['id' => 3, 'name_component' => 'segunda lengua', 'id_study_field' => 1],
            ['id' => 4, 'name_component' => 'medio ambiente', 'id_study_field' => 1],
            ['id' => 5, 'name_component' => 'formación socio humanística', 'id_study_field' => 1],
            ['id' => 6, 'name_component' => 'matemática y estadística', 'id_study_field' => 2],
            ['id' => 7, 'name_component' => 'física', 'id_study_field' => 2],
            ['id' => 8, 'name_component' => 'matemáticas aplicadas', 'id_study_field' => 2],
            ['id' => 9, 'name_component' => 'electrónica', 'id_study_field' => 3],
            ['id' => 10, 'name_component' => 'comunicaciones', 'id_study_field' => 3],
            ['id' => 11, 'name_component' => 'informática y comunicación', 'id_study_field' => 3],
            ['id' => 12, 'name_component' => 'desarrollo de software', 'id_study_field' => 3],
            ['id' => 13, 'name_component' => 'ingeniería de software', 'id_study_field' => 3],
            ['id' => 14, 'name_component' => 'practica', 'id_study_field' => 3],
            ['id' => 15, 'name_component' => 'administración y organización', 'id_study_field' => 3],
            ['id' => 16, 'name_component' => 'electiva optativa y especializada', 'id_study_field' => 3],

            // NUEVOS COMPONENTES
            ['id' => 17, 'name_component' => 'fundamentacion', 'id_study_field' => 3],
            ['id' => 18, 'name_component' => 'publico', 'id_study_field' => 3],
            ['id' => 19, 'name_component' => 'privado', 'id_study_field' => 3],
            ['id' => 20, 'name_component' => 'laboral', 'id_study_field' => 3],
            ['id' => 21, 'name_component' => 'penal', 'id_study_field' => 3],
            ['id' => 22, 'name_component' => 'practicas en entidades', 'id_study_field' => 3],
        ]);

        // Semestres
        DB::table('semesters')->insert([
            ['id' => 1, 'name_semester' => 'primer semestre'],
            ['id' => 2, 'name_semester' => 'segundo semestre'],
            ['id' => 3, 'name_semester' => 'tercer semestre'],
            ['id' => 4, 'name_semester' => 'cuarto semestre'],
            ['id' => 5, 'name_semester' => 'quinto semestre'],
            ['id' => 6, 'name_semester' => 'sexto semestre'],
            ['id' => 7, 'name_semester' => 'séptimo semestre'],
            ['id' => 8, 'name_semester' => 'octavo semestre'],
            ['id' => 9, 'name_semester' => 'noveno semestre'],
            ['id' => 10, 'name_semester' => 'décimo semestre'],
        ]);

        // Tipos de Curso
        DB::table('course_types')->insert([
            ['id' => 1, 'name_course_type' => 'teórico'],
            ['id' => 2, 'name_course_type' => 'teórico práctico'],
            ['id' => 3, 'name_course_type' => 'práctico'],
        ]);

        // Cursos
        DB::table('courses')->insert([
            ['id' => 1, 'name_course' => 'algebra moderna', 'credit' => 4, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190101'],
            ['id' => 2, 'name_course' => 'introducción a la ingeniería', 'credit' => 2, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190102'],
            ['id' => 3, 'name_course' => 'introducción a la programación', 'credit' => 3, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 1, 'id_course_type' => 2, 'course_code' => '12190103'],
            ['id' => 4, 'name_course' => 'catedra autónoma', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190104'],
            ['id' => 5, 'name_course' => 'lectura y escritura de textos', 'credit' => 2, 'id_modality' => 1, 'id_component' => 2, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190105'],
            ['id' => 6, 'name_course' => 'educación y legislación ambiental', 'credit' => 3, 'id_modality' => 1, 'id_component' => 4, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190106'],
            ['id' => 7, 'name_course' => 'calculo I', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190204'],
            ['id' => 8, 'name_course' => 'algebra lineal', 'credit' => 2, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190205'],
            ['id' => 9, 'name_course' => 'física I', 'credit' => 3, 'id_modality' => 1, 'id_component' => 7, 'id_semester' => 2, 'id_course_type' => 2, 'course_code' => '12190206'],
            ['id' => 10, 'name_course' => 'programación I', 'credit' => 4, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 2, 'id_course_type' => 2, 'course_code' => '12190207'],
            ['id' => 11, 'name_course' => 'cultura emprendedora', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190208'],
            ['id' => 12, 'name_course' => 'ambiente y sociedad', 'credit' => 3, 'id_modality' => 1, 'id_component' => 4, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190209'],
            ['id' => 13, 'name_course' => 'competencias ciudadanas', 'credit' => 1, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190210'],
            ['id' => 14, 'name_course' => 'calculo II', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '12190308'],
            ['id' => 15, 'name_course' => 'matemáticas discretas', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '12190309'],
            ['id' => 16, 'name_course' => 'física II', 'credit' => 3, 'id_modality' => 1, 'id_component' => 7, 'id_semester' => 3, 'id_course_type' => 2, 'course_code' => '12190310'],
            ['id' => 17, 'name_course' => 'arquitectura de computadores', 'credit' => 3, 'id_modality' => 1, 'id_component' => 9, 'id_semester' => 3, 'id_course_type' => 2, 'course_code' => '12190311'],
            ['id' => 18, 'name_course' => 'programación II', 'credit' => 4, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 3, 'id_course_type' => 2, 'course_code' => '12190312'],
            ['id' => 19, 'name_course' => 'ingles I', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '12190313'],
            ['id' => 20, 'name_course' => 'ecuaciones diferenciales', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190413'],
            ['id' => 21, 'name_course' => 'base de datos I', 'credit' => 4, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 4, 'id_course_type' => 2, 'course_code' => '12190414'],
            ['id' => 22, 'name_course' => 'estructura de datos', 'credit' => 4, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 4, 'id_course_type' => 2, 'course_code' => '12190415'],
            ['id' => 23, 'name_course' => 'ingeniería del software I', 'credit' => 4, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190416'],
            ['id' => 24, 'name_course' => 'ingles II', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190417'],
            ['id' => 25, 'name_course' => 'transformación digital e innovación', 'credit' => 1, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190418'],
            ['id' => 26, 'name_course' => 'probabilidad computacional y estadística', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190517'],
            ['id' => 27, 'name_course' => 'base de datos II', 'credit' => 4, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 5, 'id_course_type' => 2, 'course_code' => '12190518'],
            ['id' => 28, 'name_course' => 'complejidad algorítmica', 'credit' => 3, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190519'],
            ['id' => 29, 'name_course' => 'desarrollo aplicaciones web', 'credit' => 2, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 5, 'id_course_type' => 2, 'course_code' => '12190520'],
            ['id' => 30, 'name_course' => 'ingeniería del software II', 'credit' => 4, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190521'],
            ['id' => 31, 'name_course' => 'ingles III', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190522'],
            ['id' => 32, 'name_course' => 'análisis numérico', 'credit' => 3, 'id_modality' => 1, 'id_component' => 8, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190622'],
            ['id' => 33, 'name_course' => 'arquitectura de sistema operativo', 'credit' => 3, 'id_modality' => 1, 'id_component' => 10, 'id_semester' => 6, 'id_course_type' => 2, 'course_code' => '12190623'],
            ['id' => 34, 'name_course' => 'base de datos avanzadas', 'credit' => 2, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 6, 'id_course_type' => 2, 'course_code' => '12190624'],
            ['id' => 35, 'name_course' => 'teoría de la computación', 'credit' => 3, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190625'],
            ['id' => 36, 'name_course' => 'desarrollo de aplicaciones móviles', 'credit' => 2, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 6, 'id_course_type' => 2, 'course_code' => '12190626'],
            ['id' => 37, 'name_course' => 'calidad del software I', 'credit' => 3, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190627'],
            ['id' => 38, 'name_course' => 'ingles IV', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190628'],
            ['id' => 39, 'name_course' => 'modelado para la computación', 'credit' => 3, 'id_modality' => 1, 'id_component' => 8, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190728'],
            ['id' => 40, 'name_course' => 'redes de computadores', 'credit' => 3, 'id_modality' => 1, 'id_component' => 10, 'id_semester' => 7, 'id_course_type' => 2, 'course_code' => '12190729'],
            ['id' => 41, 'name_course' => 'seguridad informática', 'credit' => 3, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190730'],
            ['id' => 42, 'name_course' => 'arquitectura de software', 'credit' => 3, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 7, 'id_course_type' => 2, 'course_code' => '12190731'],
            ['id' => 43, 'name_course' => 'calidad de software II', 'credit' => 3, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190732'],
            ['id' => 44, 'name_course' => 'fundamentos y metodología de la investigación', 'credit' => 2, 'id_modality' => 1, 'id_component' => 2, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190733'],
            ['id' => 45, 'name_course' => 'herramientas para pensamiento filosófico', 'credit' => 2, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190734'],
            ['id' => 46, 'name_course' => 'gestión de redes', 'credit' => 2, 'id_modality' => 1, 'id_component' => 10, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190833'],
            ['id' => 47, 'name_course' => 'sistema de información empresarial', 'credit' => 3, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190834'],
            ['id' => 48, 'name_course' => 'electiva I (optativa)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '12190835'],
            ['id' => 49, 'name_course' => 'electiva III (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190836'],
            ['id' => 50, 'name_course' => 'electiva V (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190837'],
            ['id' => 51, 'name_course' => 'creatividad e innovación', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '12190838'],
            ['id' => 52, 'name_course' => 'taller de investigación', 'credit' => 2, 'id_modality' => 1, 'id_component' => 2, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '12190839'],
            ['id' => 53, 'name_course' => 'hci', 'credit' => 2, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 9, 'id_course_type' => 2, 'course_code' => '12190938'],
            ['id' => 54, 'name_course' => 'practica profesional', 'credit' => 2, 'id_modality' => 1, 'id_component' => 14, 'id_semester' => 9, 'id_course_type' => 3, 'course_code' => '12190939'],
            ['id' => 55, 'name_course' => 'gestión tecnológica y financiera', 'credit' => 2, 'id_modality' => 1, 'id_component' => 15, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '12190940'],
            ['id' => 56, 'name_course' => 'electiva II (optativa)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '12190941'],
            ['id' => 57, 'name_course' => 'electiva IV (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 9, 'id_course_type' => 2, 'course_code' => '12190942'],
            ['id' => 58, 'name_course' => 'electiva VI (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 9, 'id_course_type' => 2, 'course_code' => '12190943'],
            ['id' => 59, 'name_course' => 'inteligencia social y pensamiento critico', 'credit' => 2, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '12190944'],

            // ESPECIALIZACION
            ['id' => 60, 'name_course' => 'Desarrollo de la Ciencia del Derecho Penal', 'credit' => 3, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150101'],
            ['id' => 61, 'name_course' => 'Constitución y Fuentes del Derecho Penal', 'credit' => 2, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150102'],
            ['id' => 62, 'name_course' => 'Tipicidad e Imputación Objetiva', 'credit' => 2, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150103'],
            ['id' => 63, 'name_course' => 'Antijuricidad y Culpabilidad', 'credit' => 3, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150104'],
            ['id' => 64, 'name_course' => 'Sistema de Responsabilidad del Adolescente', 'credit' => 2, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150105'],
            ['id' => 65, 'name_course' => 'Los Modelos Procesales Penales Nacional e Internacional', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150206'],
            ['id' => 66, 'name_course' => 'Las Audiencias y las Formas de Evitacion del Proceso como Estructura de Gestion y Emprendimiento en el Proceso Penal Colombiano', 'credit' => 3, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150207'],
            ['id' => 67, 'name_course' => 'La Pena, su Determinacion Legal y Judicial', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150208'],
            ['id' => 68, 'name_course' => 'Derecho Internacional Penal', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150209'],
            ['id' => 69, 'name_course' => 'Derecho Penal Económico y Globalización', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150210'],
            ['id' => 70, 'name_course' => 'Electiva', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150211'],

            // DERECHO
            // SEMESTRE 1
            ['id' => 71, 'name_course' => 'Introducción al derecho', 'credit' => 4, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 72, 'name_course' => 'Teoría de la Constitución', 'credit' => 3, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 73, 'name_course' => 'Teoría del Estado, el poder y la justicia', 'credit' => 3, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 74, 'name_course' => 'Teoría económica y economía colombiana', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 75, 'name_course' => 'Psicología del comportamiento', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 76, 'name_course' => 'Sociología jurídica', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 2
            ['id' => 77, 'name_course' => 'Derecho civil: fundamentos y sujetos', 'credit' => 4, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 78, 'name_course' => 'Derecho constitucional Colombiano', 'credit' => 4, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 79, 'name_course' => 'Derecho y recursos tecnológicos', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 80, 'name_course' => 'Hermenéutica jurídica', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 81, 'name_course' => 'Teoría general del proceso', 'credit' => 4, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 3
            ['id' => 82, 'name_course' => 'Derecho penal, parte general', 'credit' => 2, 'id_modality' => 1, 'id_component' => 21, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 83, 'name_course' => 'Bienes', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 84, 'name_course' => 'Derechos humanos y derecho internacional humanitario', 'credit' => 2, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 85, 'name_course' => 'Procedimiento civil', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 3, 'id_course_type' => 2, 'course_code' => '0'],
            ['id' => 86, 'name_course' => 'Argumentación jurídica aplicada', 'credit' => 3, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 4
            ['id' => 87, 'name_course' => 'Acciones constitucionales y litigio estratégico', 'credit' => 2, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 4, 'id_course_type' => 2, 'course_code' => '0'],
            ['id' => 88, 'name_course' => 'Obligaciones', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 4, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 89, 'name_course' => 'Procedimiento civil Especial', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 4, 'id_course_type' => 2, 'course_code' => '0'],
            ['id' => 90, 'name_course' => 'Derecho laboral individual', 'credit' => 3, 'id_modality' => 1, 'id_component' => 20, 'id_semester' => 4, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 91, 'name_course' => 'Teoría del delito', 'credit' => 3, 'id_modality' => 1, 'id_component' => 21, 'id_semester' => 4, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 5
            ['id' => 92, 'name_course' => 'Mecanismos Alternativos de Solución de Conflictos', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 93, 'name_course' => 'Derecho administrativo General', 'credit' => 3, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 94, 'name_course' => 'Derecho penal especial', 'credit' => 3, 'id_modality' => 1, 'id_component' => 21, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 95, 'name_course' => 'Seguridad social', 'credit' => 3, 'id_modality' => 1, 'id_component' => 20, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 96, 'name_course' => 'Derecho de Familia', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 6
            ['id' => 97, 'name_course' => 'Procedimiento Penal', 'credit' => 4, 'id_modality' => 1, 'id_component' => 21, 'id_semester' => 6, 'id_course_type' => 2, 'course_code' => '0'],
            ['id' => 98, 'name_course' => 'Consultorio jurídico I (Privado)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 99, 'name_course' => 'Derecho administrativo Colombiano', 'credit' => 3, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 100, 'name_course' => 'Derecho Probatorio', 'credit' => 2, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 101, 'name_course' => 'Procedimiento laboral', 'credit' => 2, 'id_modality' => 1, 'id_component' => 20, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 102, 'name_course' => 'Contratos civiles', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 7
            ['id' => 103, 'name_course' => 'Investigación socio jurídica', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 104, 'name_course' => 'Consultorio jurídico II Penal', 'credit' => 1, 'id_modality' => 1, 'id_component' => 21, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 105, 'name_course' => 'Comercial general', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 106, 'name_course' => 'Consultorio jurídico III Laboral', 'credit' => 2, 'id_modality' => 1, 'id_component' => 20, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 107, 'name_course' => 'Sucesiones', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 108, 'name_course' => 'Procesal Administrativo', 'credit' => 3, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 8
            ['id' => 109, 'name_course' => 'Consultorio Jurídico IV Público', 'credit' => 2, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 110, 'name_course' => 'Electiva de profundización I (Penal)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 21, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 111, 'name_course' => 'Filosofía del Derecho', 'credit' => 2, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 112, 'name_course' => 'Contratación Estatal', 'credit' => 2, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 113, 'name_course' => 'Laboral colectivo', 'credit' => 2, 'id_modality' => 1, 'id_component' => 20, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 114, 'name_course' => 'Títulos valores', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 115, 'name_course' => 'Ética Profesional', 'credit' => 1, 'id_modality' => 1, 'id_component' => 17, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '0'],

            // SEMESTRE 9
            ['id' => 116, 'name_course' => 'Derecho Internacional Público', 'credit' => 2, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 117, 'name_course' => 'Práctica en Entidades', 'credit' => 2, 'id_modality' => 1, 'id_component' => 22, 'id_semester' => 9, 'id_course_type' => 3, 'course_code' => '0'], // Práctico
            ['id' => 118, 'name_course' => 'Electiva de profundización II (Público)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 119, 'name_course' => 'Electiva de profundización III (Privado)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 120, 'name_course' => 'Legislación tributaria y Hacienda pública', 'credit' => 3, 'id_modality' => 1, 'id_component' => 18, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 121, 'name_course' => 'Electiva de profundización IV (Laboral)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 20, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 122, 'name_course' => 'Sociedades', 'credit' => 3, 'id_modality' => 1, 'id_component' => 19, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '0'],

            // CAMPO CUMUN
            ['id' => 123, 'name_course' => 'Modelo de Negocio', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 4, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 124, 'name_course' => 'Habilidades directivas', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 125, 'name_course' => 'Cátedra Autónoma II', 'credit' => 1, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 126, 'name_course' => 'Electiva I (Socio Humanistica CC)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '0'],
            ['id' => 127, 'name_course' => 'Electiva II (Socio Humanistica CC)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '0'],
        ]);

        //Relations programs and courses
        DB::table('programs_courses_relationships')->insert([
            // SOFTWARE
            ['id' => 1, 'id_program' => 3, 'id_course' => 1],
            ['id' => 2, 'id_program' => 3, 'id_course' => 2],
            ['id' => 3, 'id_program' => 3, 'id_course' => 3],
            ['id' => 4, 'id_program' => 3, 'id_course' => 7],
            ['id' => 5, 'id_program' => 3, 'id_course' => 8],
            ['id' => 6, 'id_program' => 3, 'id_course' => 9],
            ['id' => 7, 'id_program' => 3, 'id_course' => 10],
            ['id' => 8, 'id_program' => 3, 'id_course' => 14],
            ['id' => 9, 'id_program' => 3, 'id_course' => 15],
            ['id' => 10, 'id_program' => 3, 'id_course' => 16],
            ['id' => 11, 'id_program' => 3, 'id_course' => 17],
            ['id' => 12, 'id_program' => 3, 'id_course' => 18],
            ['id' => 13, 'id_program' => 3, 'id_course' => 20],
            ['id' => 14, 'id_program' => 3, 'id_course' => 21],
            ['id' => 15, 'id_program' => 3, 'id_course' => 22],
            ['id' => 16, 'id_program' => 3, 'id_course' => 23],
            ['id' => 17, 'id_program' => 3, 'id_course' => 26],
            ['id' => 18, 'id_program' => 3, 'id_course' => 27],
            ['id' => 19, 'id_program' => 3, 'id_course' => 28],
            ['id' => 20, 'id_program' => 3, 'id_course' => 29],
            ['id' => 21, 'id_program' => 3, 'id_course' => 30],
            ['id' => 22, 'id_program' => 3, 'id_course' => 32],
            ['id' => 23, 'id_program' => 3, 'id_course' => 33],
            ['id' => 24, 'id_program' => 3, 'id_course' => 34],
            ['id' => 25, 'id_program' => 3, 'id_course' => 35],
            ['id' => 26, 'id_program' => 3, 'id_course' => 36],
            ['id' => 27, 'id_program' => 3, 'id_course' => 37],
            ['id' => 28, 'id_program' => 3, 'id_course' => 39],
            ['id' => 29, 'id_program' => 3, 'id_course' => 40],
            ['id' => 30, 'id_program' => 3, 'id_course' => 41],
            ['id' => 31, 'id_program' => 3, 'id_course' => 42],
            ['id' => 32, 'id_program' => 3, 'id_course' => 43],
            ['id' => 33, 'id_program' => 3, 'id_course' => 46],
            ['id' => 34, 'id_program' => 3, 'id_course' => 47],
            ['id' => 35, 'id_program' => 3, 'id_course' => 48],
            ['id' => 36, 'id_program' => 3, 'id_course' => 49],
            ['id' => 37, 'id_program' => 3, 'id_course' => 50],
            ['id' => 38, 'id_program' => 3, 'id_course' => 53],
            ['id' => 39, 'id_program' => 3, 'id_course' => 54],
            ['id' => 40, 'id_program' => 3, 'id_course' => 55],
            ['id' => 41, 'id_program' => 3, 'id_course' => 56],
            ['id' => 42, 'id_program' => 3, 'id_course' => 57],
            ['id' => 43, 'id_program' => 3, 'id_course' => 58],

            //CAMPO COMUN
            ['id' => 44, 'id_program' => null, 'id_course' => 4],
            ['id' => 45, 'id_program' => null, 'id_course' => 5],
            ['id' => 46, 'id_program' => null, 'id_course' => 6],
            ['id' => 47, 'id_program' => null, 'id_course' => 11],
            ['id' => 48, 'id_program' => null, 'id_course' => 12],
            ['id' => 49, 'id_program' => null, 'id_course' => 13],
            ['id' => 50, 'id_program' => null, 'id_course' => 19],
            ['id' => 51, 'id_program' => null, 'id_course' => 24],
            ['id' => 52, 'id_program' => null, 'id_course' => 25],
            ['id' => 53, 'id_program' => null, 'id_course' => 31],
            ['id' => 54, 'id_program' => null, 'id_course' => 38],
            ['id' => 55, 'id_program' => null, 'id_course' => 44],
            ['id' => 56, 'id_program' => null, 'id_course' => 45],
            ['id' => 57, 'id_program' => null, 'id_course' => 51],
            ['id' => 58, 'id_program' => null, 'id_course' => 52],
            ['id' => 59, 'id_program' => null, 'id_course' => 59],

            // ESPECIALIZACION
            ['id' => 60, 'id_program' => 13, 'id_course' => 60],
            ['id' => 61, 'id_program' => 13, 'id_course' => 61],
            ['id' => 62, 'id_program' => 13, 'id_course' => 62],
            ['id' => 63, 'id_program' => 13, 'id_course' => 63],
            ['id' => 64, 'id_program' => 13, 'id_course' => 64],
            ['id' => 65, 'id_program' => 13, 'id_course' => 65],
            ['id' => 66, 'id_program' => 13, 'id_course' => 66],
            ['id' => 67, 'id_program' => 13, 'id_course' => 67],
            ['id' => 68, 'id_program' => 13, 'id_course' => 68],
            ['id' => 69, 'id_program' => 13, 'id_course' => 69],
            ['id' => 70, 'id_program' => 13, 'id_course' => 70],

            // NUEVOS REGISTROS
            ['id' => 71, 'id_program' => 6, 'id_course' => 71],
            ['id' => 72, 'id_program' => 6, 'id_course' => 72],
            ['id' => 73, 'id_program' => 6, 'id_course' => 73],
            ['id' => 74, 'id_program' => 6, 'id_course' => 74],
            ['id' => 75, 'id_program' => 6, 'id_course' => 75],
            ['id' => 76, 'id_program' => 6, 'id_course' => 76],
            ['id' => 77, 'id_program' => 6, 'id_course' => 77],
            ['id' => 78, 'id_program' => 6, 'id_course' => 78],
            ['id' => 79, 'id_program' => 6, 'id_course' => 79],
            ['id' => 80, 'id_program' => 6, 'id_course' => 80],
            ['id' => 81, 'id_program' => 6, 'id_course' => 81],
            ['id' => 82, 'id_program' => 6, 'id_course' => 82],
            ['id' => 83, 'id_program' => 6, 'id_course' => 83],
            ['id' => 84, 'id_program' => 6, 'id_course' => 84],
            ['id' => 85, 'id_program' => 6, 'id_course' => 85],
            ['id' => 86, 'id_program' => 6, 'id_course' => 86],
            ['id' => 87, 'id_program' => 6, 'id_course' => 87],
            ['id' => 88, 'id_program' => 6, 'id_course' => 88],
            ['id' => 89, 'id_program' => 6, 'id_course' => 89],
            ['id' => 90, 'id_program' => 6, 'id_course' => 90],
            ['id' => 91, 'id_program' => 6, 'id_course' => 91],
            ['id' => 92, 'id_program' => 6, 'id_course' => 92],
            ['id' => 93, 'id_program' => 6, 'id_course' => 93],
            ['id' => 94, 'id_program' => 6, 'id_course' => 94],
            ['id' => 95, 'id_program' => 6, 'id_course' => 95],
            ['id' => 96, 'id_program' => 6, 'id_course' => 96],
            ['id' => 97, 'id_program' => 6, 'id_course' => 97],
            ['id' => 98, 'id_program' => 6, 'id_course' => 98],
            ['id' => 99, 'id_program' => 6, 'id_course' => 99],
            ['id' => 100, 'id_program' => 6, 'id_course' => 100],
            ['id' => 101, 'id_program' => 6, 'id_course' => 101],
            ['id' => 102, 'id_program' => 6, 'id_course' => 102],
            ['id' => 103, 'id_program' => 6, 'id_course' => 103],
            ['id' => 104, 'id_program' => 6, 'id_course' => 104],
            ['id' => 105, 'id_program' => 6, 'id_course' => 105],
            ['id' => 106, 'id_program' => 6, 'id_course' => 106],
            ['id' => 107, 'id_program' => 6, 'id_course' => 107],
            ['id' => 108, 'id_program' => 6, 'id_course' => 108],
            ['id' => 109, 'id_program' => 6, 'id_course' => 109],
            ['id' => 110, 'id_program' => 6, 'id_course' => 110],
            ['id' => 111, 'id_program' => 6, 'id_course' => 111],
            ['id' => 112, 'id_program' => 6, 'id_course' => 112],
            ['id' => 113, 'id_program' => 6, 'id_course' => 113],
            ['id' => 114, 'id_program' => 6, 'id_course' => 114],
            ['id' => 115, 'id_program' => 6, 'id_course' => 115],
            ['id' => 116, 'id_program' => 6, 'id_course' => 116],
            ['id' => 117, 'id_program' => 6, 'id_course' => 117],
            ['id' => 118, 'id_program' => 6, 'id_course' => 118],
            ['id' => 119, 'id_program' => 6, 'id_course' => 119],
            ['id' => 120, 'id_program' => 6, 'id_course' => 120],
            ['id' => 121, 'id_program' => 6, 'id_course' => 121],
            ['id' => 122, 'id_program' => 6, 'id_course' => 122],

            // CAMPO CUMUN V2
            ['id' => 123, 'id_program' => null, 'id_course' => 123],
            ['id' => 124, 'id_program' => null, 'id_course' => 124],
            ['id' => 125, 'id_program' => null, 'id_course' => 125],
            ['id' => 126, 'id_program' => null, 'id_course' => 126],
            ['id' => 127, 'id_program' => null, 'id_course' => 127],

        ]);

        //Relation user
        DB::table('relations_users')->insert([
            ['id_relation' => null, 'id_user' => 7],
            ['id_relation' => 37, 'id_user' => 7],

            ['id_relation' => 12, 'id_user' => 8],  // For course 18
            ['id_relation' => 39, 'id_user' => 8],  // For course 54
            ['id_relation' => 26, 'id_user' => 8],  // For course 36
            ['id_relation' => 42, 'id_user' => 8],  // For course 57

            ['id_relation' => 52, 'id_user' => 9],  // id_course 25 
            ['id_relation' => null, 'id_user' => 9],  // id_course null
            ['id_relation' => 11, 'id_user' => 9],  // id_course 17 
            ['id_relation' => 23, 'id_user' => 9],  // id_course 33 
            ['id_relation' => null, 'id_user' => 9],  // id_course null
            ['id_relation' => 40, 'id_user' => 9],  // id_course 55 
            ['id_relation' => 29, 'id_user' => 9],  // id_course 40 

            ['id_relation' => 7, 'id_user' => 10],   // id_course => 10
            ['id_relation' => 35, 'id_user' => 10],  // id_course => 48
            ['id_relation' => 16, 'id_user' => 10],  // id_course => 23
            ['id_relation' => 3, 'id_user' => 10],   // id_course => 3
            ['id_relation' => 17, 'id_user' => 10],  // id_course => 26
            ['id_relation' => null, 'id_user' => 10], // id_course => null

            ['id_relation' => 20, 'id_user' => 11], // id_course => 29
            ['id_relation' => 26, 'id_user' => 11], // id_course => 36
            ['id_relation' => 12, 'id_user' => 11], // id_course => 18
            ['id_relation' => 41, 'id_user' => 11], // id_course => 56
            ['id_relation' => 3,  'id_user' => 11], // id_course => 3

            ['id_relation' => 15, 'id_user' => 12], // id_course => 22
            ['id_relation' => 19, 'id_user' => 12], // id_course => 28
            ['id_relation' => 21, 'id_user' => 12], // id_course => 30
            ['id_relation' => 27, 'id_user' => 12], // id_course => 37
            ['id_relation' => 32, 'id_user' => 12], // id_course => 43
            ['id_relation' => 34, 'id_user' => 12], // id_course => 47
            ['id_relation' => 31, 'id_user' => 12], // id_course => 42

            ['id_relation' => 24, 'id_user' => 13], // id_course => 34
            ['id_relation' => 41, 'id_user' => 13], // id_course => 56
            ['id_relation' => 2,  'id_user' => 13], // id_course => 2
            ['id_relation' => 28, 'id_user' => 13], // id_course => 39
            ['id_relation' => 3,  'id_user' => 13], // id_course => 3
            ['id_relation' => 9,  'id_user' => 13], // id_course => 15
            ['id_relation' => 18, 'id_user' => 13], // id_course => 27
            ['id_relation' => 19, 'id_user' => 13], // id_course => 28

            ['id_relation' => 14, 'id_user' => 14], // id_course => 21
            ['id_relation' => 15, 'id_user' => 14], // id_course => 22
            ['id_relation' => 30, 'id_user' => 14], // id_course => 41
            ['id_relation' => 33, 'id_user' => 14], // id_course => 46
            ['id_relation' => 11, 'id_user' => 14], // id_course => 17
            ['id_relation' => 3,  'id_user' => 14], // id_course => 3

            ['id_relation' => 21, 'id_user' => 15], // id_course => 30
            ['id_relation' => 20, 'id_user' => 15], // id_course => 29
            ['id_relation' => 18, 'id_user' => 15], // id_course => 27
            ['id_relation' => 45, 'id_user' => 15], // id_course => 5 
            ['id_relation' => 7,  'id_user' => 15], // id_course => 10

            ['id_relation' => 38, 'id_user' => 16], // id_course => 53

            ['id_relation' => 43, 'id_user' => 17], // id_course => 58

            ['id_relation' => 36, 'id_user' => 18], // id_course => 49

            ['id_relation' => null, 'id_user' => 19], // id_course => null
            ['id_relation' => 13,   'id_user' => 19], // id_course => 20
            ['id_relation' => null, 'id_user' => 19], // id_course => null
            ['id_relation' => 9,    'id_user' => 19], // id_course => 15

            ['id_relation' => null, 'id_user' => 20], // id_course => null
            ['id_relation' => 1,    'id_user' => 20], // id_course => 1
            ['id_relation' => 5,    'id_user' => 20], // id_course => 8
            ['id_relation' => null, 'id_user' => 20], // id_course => null
            ['id_relation' => null, 'id_user' => 20], // id_course => null

            ['id_relation' => 8,    'id_user' => 21], // id_course => 14
            ['id_relation' => null, 'id_user' => 21], // id_course => null
            ['id_relation' => 22,   'id_user' => 21], // id_course => 32
            ['id_relation' => 9,    'id_user' => 21], // id_course => 15
            ['id_relation' => null, 'id_user' => 21], // id_course => null

            ['id_relation' => 4,    'id_user' => 22], // id_course => 7
            ['id_relation' => null, 'id_user' => 22], // id_course => null
            ['id_relation' => null, 'id_user' => 22], // id_course => null
            ['id_relation' => 8,    'id_user' => 22], // id_course => 14

            ['id_relation' => 17,   'id_user' => 23], // id_course => 26
            ['id_relation' => null, 'id_user' => 23], // id_course => null
            ['id_relation' => null, 'id_user' => 23], // id_course => null
            ['id_relation' => null, 'id_user' => 23], // id_course => null

            ['id_relation' => 2,    'id_user' => 24], // id_course => 2 
            ['id_relation' => 3,    'id_user' => 24], // id_course => 3 
            ['id_relation' => null, 'id_user' => 24], // id_course => null
            ['id_relation' => null, 'id_user' => 24], // id_course => null
            ['id_relation' => null, 'id_user' => 24], // id_course => null
            ['id_relation' => 5,    'id_user' => 24], // id_course => 8 

            ['id_relation' => 1,    'id_user' => 25], // id_course => 1 
            ['id_relation' => 6,    'id_user' => 25], // id_course => 9
            ['id_relation' => null, 'id_user' => 25], // id_course => null
            ['id_relation' => 1,    'id_user' => 25], // id_course => 1 
            ['id_relation' => null, 'id_user' => 25], // id_course => null
            ['id_relation' => 5,    'id_user' => 25], // id_course => 8 

            // DERECHO

            // Usuario 32
            ['id_relation' => 71, 'id_user' => 27],
            ['id_relation' => 72, 'id_user' => 27],
            ['id_relation' => 73, 'id_user' => 27],
            ['id_relation' => 74, 'id_user' => 27],
            ['id_relation' => 75, 'id_user' => 27],
            ['id_relation' => 76, 'id_user' => 27],
            ['id_relation' => 77, 'id_user' => 27],
            ['id_relation' => 78, 'id_user' => 27],
            ['id_relation' => 79, 'id_user' => 27],
            ['id_relation' => 80, 'id_user' => 27],
            ['id_relation' => 81, 'id_user' => 27],
            ['id_relation' => 82, 'id_user' => 27],
            ['id_relation' => 83, 'id_user' => 27],
            ['id_relation' => 84, 'id_user' => 27],
            ['id_relation' => 85, 'id_user' => 27],
            ['id_relation' => 86, 'id_user' => 27],
            ['id_relation' => 87, 'id_user' => 27],
            ['id_relation' => 88, 'id_user' => 27],
            ['id_relation' => 89, 'id_user' => 27],
            ['id_relation' => 90, 'id_user' => 27],
            ['id_relation' => 91, 'id_user' => 27],
            ['id_relation' => 92, 'id_user' => 27],
            ['id_relation' => 93, 'id_user' => 27],
            ['id_relation' => 94, 'id_user' => 27],
            ['id_relation' => 95, 'id_user' => 27],
            ['id_relation' => 96, 'id_user' => 27],
            ['id_relation' => 97, 'id_user' => 27],
            ['id_relation' => 98, 'id_user' => 27],
            ['id_relation' => 99, 'id_user' => 27],
            ['id_relation' => 100, 'id_user' => 27],
            ['id_relation' => 101, 'id_user' => 27],
            ['id_relation' => 102, 'id_user' => 27],
            ['id_relation' => 103, 'id_user' => 27],
            ['id_relation' => 104, 'id_user' => 27],
            ['id_relation' => 105, 'id_user' => 27],
            ['id_relation' => 106, 'id_user' => 27],
            ['id_relation' => 107, 'id_user' => 27],
            ['id_relation' => 108, 'id_user' => 27],
            ['id_relation' => 109, 'id_user' => 27],
            ['id_relation' => 110, 'id_user' => 27],
            ['id_relation' => 111, 'id_user' => 27],
            ['id_relation' => 112, 'id_user' => 27],
            ['id_relation' => 113, 'id_user' => 27],
            ['id_relation' => 114, 'id_user' => 27],
            ['id_relation' => 115, 'id_user' => 27],
            ['id_relation' => 116, 'id_user' => 27],
            ['id_relation' => 117, 'id_user' => 27],
            ['id_relation' => 118, 'id_user' => 27],
            ['id_relation' => 119, 'id_user' => 27],
            ['id_relation' => 120, 'id_user' => 27],
            ['id_relation' => 121, 'id_user' => 27],
            ['id_relation' => 122, 'id_user' => 27],
            ['id_relation' => 123, 'id_user' => 27],
            ['id_relation' => 124, 'id_user' => 27],
            ['id_relation' => 125, 'id_user' => 27],
            ['id_relation' => 126, 'id_user' => 27],
            ['id_relation' => 127, 'id_user' => 27],

            // USUER 28
            ['id_relation' => 71,  'id_user' => 28],
            ['id_relation' => 72,  'id_user' => 28],
            ['id_relation' => 73,  'id_user' => 28],
            ['id_relation' => 74,  'id_user' => 28],
            ['id_relation' => 75,  'id_user' => 28],
            ['id_relation' => 76,  'id_user' => 28],
            ['id_relation' => 77,  'id_user' => 28],
            ['id_relation' => 78,  'id_user' => 28],
            ['id_relation' => 79,  'id_user' => 28],
            ['id_relation' => 80,  'id_user' => 28],
            ['id_relation' => 81,  'id_user' => 28],
            ['id_relation' => 82,  'id_user' => 28],
            ['id_relation' => 83,  'id_user' => 28],
            ['id_relation' => 84,  'id_user' => 28],
            ['id_relation' => 85,  'id_user' => 28],
            ['id_relation' => 86,  'id_user' => 28],
            ['id_relation' => 87,  'id_user' => 28],
            ['id_relation' => 88,  'id_user' => 28],
            ['id_relation' => 89,  'id_user' => 28],
            ['id_relation' => 90,  'id_user' => 28],
            ['id_relation' => 91,  'id_user' => 28],
            ['id_relation' => 92,  'id_user' => 28],
            ['id_relation' => 93,  'id_user' => 28],
            ['id_relation' => 94,  'id_user' => 28],
            ['id_relation' => 95,  'id_user' => 28],
            ['id_relation' => 96,  'id_user' => 28],
            ['id_relation' => 97,  'id_user' => 28],
            ['id_relation' => 98,  'id_user' => 28],
            ['id_relation' => 99,  'id_user' => 28],
            ['id_relation' => 100, 'id_user' => 28],
            ['id_relation' => 101, 'id_user' => 28],
            ['id_relation' => 102, 'id_user' => 28],
            ['id_relation' => 103, 'id_user' => 28],
            ['id_relation' => 104, 'id_user' => 28],
            ['id_relation' => 105, 'id_user' => 28],
            ['id_relation' => 106, 'id_user' => 28],
            ['id_relation' => 107, 'id_user' => 28],
            ['id_relation' => 108, 'id_user' => 28],
            ['id_relation' => 109, 'id_user' => 28],
            ['id_relation' => 110, 'id_user' => 28],
            ['id_relation' => 111, 'id_user' => 28],
            ['id_relation' => 112, 'id_user' => 28],
            ['id_relation' => 113, 'id_user' => 28],
            ['id_relation' => 114, 'id_user' => 28],
            ['id_relation' => 115, 'id_user' => 28],
            ['id_relation' => 116, 'id_user' => 28],
            ['id_relation' => 117, 'id_user' => 28],
            ['id_relation' => 118, 'id_user' => 28],
            ['id_relation' => 119, 'id_user' => 28],
            ['id_relation' => 120, 'id_user' => 28],
            ['id_relation' => 121, 'id_user' => 28],
            ['id_relation' => 122, 'id_user' => 28],
            ['id_relation' => 123, 'id_user' => 28],
            ['id_relation' => 124, 'id_user' => 28],
            ['id_relation' => 125, 'id_user' => 28],
            ['id_relation' => 126, 'id_user' => 28],
            ['id_relation' => 127, 'id_user' => 28],

            // Usuario 30
            ['id_relation' => 71,  'id_user' => 29],
            ['id_relation' => 72,  'id_user' => 29],
            ['id_relation' => 73,  'id_user' => 29],
            ['id_relation' => 74,  'id_user' => 29],
            ['id_relation' => 75,  'id_user' => 29],
            ['id_relation' => 76,  'id_user' => 29],
            ['id_relation' => 77,  'id_user' => 29],
            ['id_relation' => 78,  'id_user' => 29],
            ['id_relation' => 79,  'id_user' => 29],
            ['id_relation' => 80,  'id_user' => 29],
            ['id_relation' => 81,  'id_user' => 29],
            ['id_relation' => 82,  'id_user' => 29],
            ['id_relation' => 83,  'id_user' => 29],
            ['id_relation' => 84,  'id_user' => 29],
            ['id_relation' => 85,  'id_user' => 29],
            ['id_relation' => 86,  'id_user' => 29],
            ['id_relation' => 87,  'id_user' => 29],
            ['id_relation' => 88,  'id_user' => 29],
            ['id_relation' => 89,  'id_user' => 29],
            ['id_relation' => 90,  'id_user' => 29],
            ['id_relation' => 91,  'id_user' => 29],
            ['id_relation' => 92,  'id_user' => 29],
            ['id_relation' => 93,  'id_user' => 29],
            ['id_relation' => 94,  'id_user' => 29],
            ['id_relation' => 95,  'id_user' => 29],
            ['id_relation' => 96,  'id_user' => 29],
            ['id_relation' => 97,  'id_user' => 29],
            ['id_relation' => 98,  'id_user' => 29],
            ['id_relation' => 99,  'id_user' => 29],
            ['id_relation' => 100, 'id_user' => 29],
            ['id_relation' => 101, 'id_user' => 29],
            ['id_relation' => 102, 'id_user' => 29],
            ['id_relation' => 103, 'id_user' => 29],
            ['id_relation' => 104, 'id_user' => 29],
            ['id_relation' => 105, 'id_user' => 29],
            ['id_relation' => 106, 'id_user' => 29],
            ['id_relation' => 107, 'id_user' => 29],
            ['id_relation' => 108, 'id_user' => 29],
            ['id_relation' => 109, 'id_user' => 29],
            ['id_relation' => 110, 'id_user' => 29],
            ['id_relation' => 111, 'id_user' => 29],
            ['id_relation' => 112, 'id_user' => 29],
            ['id_relation' => 113, 'id_user' => 29],
            ['id_relation' => 114, 'id_user' => 29],
            ['id_relation' => 115, 'id_user' => 29],
            ['id_relation' => 116, 'id_user' => 29],
            ['id_relation' => 117, 'id_user' => 29],
            ['id_relation' => 118, 'id_user' => 29],
            ['id_relation' => 119, 'id_user' => 29],
            ['id_relation' => 120, 'id_user' => 29],
            ['id_relation' => 121, 'id_user' => 29],
            ['id_relation' => 122, 'id_user' => 29],
            ['id_relation' => 123, 'id_user' => 29],
            ['id_relation' => 124, 'id_user' => 29],
            ['id_relation' => 125, 'id_user' => 29],
            ['id_relation' => 126, 'id_user' => 29],
            ['id_relation' => 127, 'id_user' => 29],

            // Usuario 30
            ['id_relation' => 71, 'id_user' => 30],
            ['id_relation' => 72, 'id_user' => 30],
            ['id_relation' => 73, 'id_user' => 30],
            ['id_relation' => 74, 'id_user' => 30],
            ['id_relation' => 75, 'id_user' => 30],
            ['id_relation' => 76, 'id_user' => 30],
            ['id_relation' => 77, 'id_user' => 30],
            ['id_relation' => 78, 'id_user' => 30],
            ['id_relation' => 79, 'id_user' => 30],
            ['id_relation' => 80, 'id_user' => 30],
            ['id_relation' => 81, 'id_user' => 30],
            ['id_relation' => 82, 'id_user' => 30],
            ['id_relation' => 83, 'id_user' => 30],
            ['id_relation' => 84, 'id_user' => 30],
            ['id_relation' => 85, 'id_user' => 30],
            ['id_relation' => 86, 'id_user' => 30],
            ['id_relation' => 87, 'id_user' => 30],
            ['id_relation' => 88, 'id_user' => 30],
            ['id_relation' => 89, 'id_user' => 30],
            ['id_relation' => 90, 'id_user' => 30],
            ['id_relation' => 91, 'id_user' => 30],
            ['id_relation' => 92, 'id_user' => 30],
            ['id_relation' => 93, 'id_user' => 30],
            ['id_relation' => 94, 'id_user' => 30],
            ['id_relation' => 95, 'id_user' => 30],
            ['id_relation' => 96, 'id_user' => 30],
            ['id_relation' => 97, 'id_user' => 30],
            ['id_relation' => 98, 'id_user' => 30],
            ['id_relation' => 99, 'id_user' => 30],
            ['id_relation' => 100, 'id_user' => 30],
            ['id_relation' => 101, 'id_user' => 30],
            ['id_relation' => 102, 'id_user' => 30],
            ['id_relation' => 103, 'id_user' => 30],
            ['id_relation' => 104, 'id_user' => 30],
            ['id_relation' => 105, 'id_user' => 30],
            ['id_relation' => 106, 'id_user' => 30],
            ['id_relation' => 107, 'id_user' => 30],
            ['id_relation' => 108, 'id_user' => 30],
            ['id_relation' => 109, 'id_user' => 30],
            ['id_relation' => 110, 'id_user' => 30],
            ['id_relation' => 111, 'id_user' => 30],
            ['id_relation' => 112, 'id_user' => 30],
            ['id_relation' => 113, 'id_user' => 30],
            ['id_relation' => 114, 'id_user' => 30],
            ['id_relation' => 115, 'id_user' => 30],
            ['id_relation' => 116, 'id_user' => 30],
            ['id_relation' => 117, 'id_user' => 30],
            ['id_relation' => 118, 'id_user' => 30],
            ['id_relation' => 119, 'id_user' => 30],
            ['id_relation' => 120, 'id_user' => 30],
            ['id_relation' => 121, 'id_user' => 30],
            ['id_relation' => 122, 'id_user' => 30],
            ['id_relation' => 123, 'id_user' => 30],
            ['id_relation' => 124, 'id_user' => 30],
            ['id_relation' => 125, 'id_user' => 30],
            ['id_relation' => 126, 'id_user' => 30],
            ['id_relation' => 127, 'id_user' => 30],

            // Usuario 31
            ['id_relation' => 71, 'id_user' => 31],
            ['id_relation' => 72, 'id_user' => 31],
            ['id_relation' => 73, 'id_user' => 31],
            ['id_relation' => 74, 'id_user' => 31],
            ['id_relation' => 75, 'id_user' => 31],
            ['id_relation' => 76, 'id_user' => 31],
            ['id_relation' => 77, 'id_user' => 31],
            ['id_relation' => 78, 'id_user' => 31],
            ['id_relation' => 79, 'id_user' => 31],
            ['id_relation' => 80, 'id_user' => 31],
            ['id_relation' => 81, 'id_user' => 31],
            ['id_relation' => 82, 'id_user' => 31],
            ['id_relation' => 83, 'id_user' => 31],
            ['id_relation' => 84, 'id_user' => 31],
            ['id_relation' => 85, 'id_user' => 31],
            ['id_relation' => 86, 'id_user' => 31],
            ['id_relation' => 87, 'id_user' => 31],
            ['id_relation' => 88, 'id_user' => 31],
            ['id_relation' => 89, 'id_user' => 31],
            ['id_relation' => 90, 'id_user' => 31],
            ['id_relation' => 91, 'id_user' => 31],
            ['id_relation' => 92, 'id_user' => 31],
            ['id_relation' => 93, 'id_user' => 31],
            ['id_relation' => 94, 'id_user' => 31],
            ['id_relation' => 95, 'id_user' => 31],
            ['id_relation' => 96, 'id_user' => 31],
            ['id_relation' => 97, 'id_user' => 31],
            ['id_relation' => 98, 'id_user' => 31],
            ['id_relation' => 99, 'id_user' => 31],
            ['id_relation' => 100, 'id_user' => 31],
            ['id_relation' => 101, 'id_user' => 31],
            ['id_relation' => 102, 'id_user' => 31],
            ['id_relation' => 103, 'id_user' => 31],
            ['id_relation' => 104, 'id_user' => 31],
            ['id_relation' => 105, 'id_user' => 31],
            ['id_relation' => 106, 'id_user' => 31],
            ['id_relation' => 107, 'id_user' => 31],
            ['id_relation' => 108, 'id_user' => 31],
            ['id_relation' => 109, 'id_user' => 31],
            ['id_relation' => 110, 'id_user' => 31],
            ['id_relation' => 111, 'id_user' => 31],
            ['id_relation' => 112, 'id_user' => 31],
            ['id_relation' => 113, 'id_user' => 31],
            ['id_relation' => 114, 'id_user' => 31],
            ['id_relation' => 115, 'id_user' => 31],
            ['id_relation' => 116, 'id_user' => 31],
            ['id_relation' => 117, 'id_user' => 31],
            ['id_relation' => 118, 'id_user' => 31],
            ['id_relation' => 119, 'id_user' => 31],
            ['id_relation' => 120, 'id_user' => 31],
            ['id_relation' => 121, 'id_user' => 31],
            ['id_relation' => 122, 'id_user' => 31],
            ['id_relation' => 123, 'id_user' => 31],
            ['id_relation' => 124, 'id_user' => 31],
            ['id_relation' => 125, 'id_user' => 31],
            ['id_relation' => 126, 'id_user' => 31],
            ['id_relation' => 127, 'id_user' => 31],

        ]);

        // Evaluaciones
        DB::table('evaluations')->insert([
            ['name_evaluation' => 'actividad 1', 'id_course_type' => 1],
            ['name_evaluation' => 'actividad 2', 'id_course_type' => 1],
            ['name_evaluation' => 'actividad 3', 'id_course_type' => 1],
            ['name_evaluation' => 'tarea 1', 'id_course_type' => 2],
            ['name_evaluation' => 'tarea 2', 'id_course_type' => 2],
            ['name_evaluation' => 'tarea 3', 'id_course_type' => 2],
            ['name_evaluation' => 'taller 1', 'id_course_type' => 3],
            ['name_evaluation' => 'taller 2', 'id_course_type' => 3],
            ['name_evaluation' => 'taller 3', 'id_course_type' => 3],
        ]);

        // Porcentajes
        DB::table('percentages')->insert([
            ['id' => 1, 'name_percentage' => 'primer porcentaje 30%', 'number_percentage' => 30],
            ['id' => 2, 'name_percentage' => 'segundo porcentaje 30%', 'number_percentage' => 30],
            ['id' => 3, 'name_percentage' => 'tercero porcentaje 40%', 'number_percentage' => 40],
        ]);

        // Estado
        DB::table('states')->insert([
            ['id' => 1, 'name_state' => 'planeación'],
            ['id' => 2, 'name_state' => 'primer revisión'],
            ['id' => 3, 'name_state' => 'segunda revisión'],
            ['id' => 4, 'name_state' => 'terminado'],
        ]);
    }
}
