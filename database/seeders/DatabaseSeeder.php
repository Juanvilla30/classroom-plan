<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
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
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'last_name' => 'suport',
            'phone' => '0',
            'email' => 'aulamanager.support@gmail.com',
            'password' => 'admin',
            'id_role' => '1',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'vicerrector',
            'last_name' => 'vice',
            'phone' => '0',
            'email' => 'vicerrectoria@uniautonoma.edu.co',
            'password' => 'vicerrectoria',
            'id_role' => '2',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Zulema Yidney',
            'last_name' => 'León Escobar',
            'phone' => '0',
            'email' => 'coordinacion.software@uniautonoma.edu.co',
            'password' => 'coordinacion',
            'id_role' => '3',
            'id_program' => '3',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'coordinador',
            'last_name' => 'energetica',
            'phone' => '0',
            'email' => 'coordinacion.energetica@uniautonoma.edu.co',
            'password' => 'coordinacion',
            'id_role' => '3',
            'id_program' => '1',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'coordinador',
            'last_name' => 'especialización en derecho penal',
            'phone' => '0',
            'email' => 'coordinacion.especializacion.penal@uniautonoma.edu.co',
            'password' => 'coordinacion',
            'id_role' => '3',
            'id_program' => '13',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'docente',
            'last_name' => 'software',
            'phone' => '0',
            'email' => 'docente.software@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '3',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'docente',
            'last_name' => 'energetica',
            'phone' => '0',
            'email' => 'docente.energetica@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '1',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'docente',
            'last_name' => 'especialización en derecho penal',
            'phone' => '0',
            'email' => 'docente.especializacion.penal@uniautonoma.edu.co',
            'password' => 'docente',
            'id_role' => '4',
            'id_program' => '13',
        ]);

        // Atributos usuario
        DB::table('user_attributes')->insert([
            ['id' => 1, 'profession' => 'Ingeniero de sistemas', 'postgraduate_studies' => 'Esp. Ingeniería del software, Esp. Gestión de proyectos, MBA Dirección proyectos', 'specific_competences' => 'Desarrollo de software - Programación modular', 'id_user' => 6],
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
            ['id' => 1, 'name_course' => 'algebra moderna', 'credit' => 4, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190101', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 2, 'name_course' => 'introducción a la ingeniería', 'credit' => 2, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190102', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 3, 'name_course' => 'introducción a la programación', 'credit' => 3, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 1, 'id_course_type' => 2, 'course_code' => '12190103', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 4, 'name_course' => 'catedra autónoma', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190104', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 5, 'name_course' => 'lectura y escritura de textos', 'credit' => 2, 'id_modality' => 1, 'id_component' => 2, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190105', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 6, 'name_course' => 'educación y legislación ambiental', 'credit' => 3, 'id_modality' => 1, 'id_component' => 4, 'id_semester' => 1, 'id_course_type' => 1, 'course_code' => '12190106', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 7, 'name_course' => 'calculo I', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190204', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 8, 'name_course' => 'algebra lineal', 'credit' => 2, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190205', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 9, 'name_course' => 'física I', 'credit' => 3, 'id_modality' => 1, 'id_component' => 7, 'id_semester' => 2, 'id_course_type' => 2, 'course_code' => '12190206', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 10, 'name_course' => 'programación I', 'credit' => 4, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 2, 'id_course_type' => 2, 'course_code' => '12190207', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 11, 'name_course' => 'cultura emprendedora', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190208', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 12, 'name_course' => 'ambiente y sociedad', 'credit' => 3, 'id_modality' => 1, 'id_component' => 4, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190209', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 13, 'name_course' => 'competencias ciudadanas', 'credit' => 1, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 2, 'id_course_type' => 1, 'course_code' => '12190210', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 14, 'name_course' => 'calculo II', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '12190308', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 15, 'name_course' => 'matemáticas discretas', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '12190309', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 16, 'name_course' => 'física II', 'credit' => 3, 'id_modality' => 1, 'id_component' => 7, 'id_semester' => 3, 'id_course_type' => 2, 'course_code' => '12190310', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 17, 'name_course' => 'arquitectura de computadores', 'credit' => 3, 'id_modality' => 1, 'id_component' => 9, 'id_semester' => 3, 'id_course_type' => 2, 'course_code' => '12190311', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 18, 'name_course' => 'programación II', 'credit' => 4, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 3, 'id_course_type' => 2, 'course_code' => '12190312', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 19, 'name_course' => 'ingles I', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 3, 'id_course_type' => 1, 'course_code' => '12190313', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 20, 'name_course' => 'ecuaciones diferenciales', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190413', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 21, 'name_course' => 'base de datos I', 'credit' => 4, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 4, 'id_course_type' => 2, 'course_code' => '12190414', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 22, 'name_course' => 'estructura de datos', 'credit' => 4, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 4, 'id_course_type' => 2, 'course_code' => '12190415', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 23, 'name_course' => 'ingeniería del software I', 'credit' => 4, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190416', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 24, 'name_course' => 'ingles II', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190417', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 25, 'name_course' => 'transformación digital e innovación', 'credit' => 1, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 4, 'id_course_type' => 3, 'course_code' => '12190418', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 26, 'name_course' => 'probabilidad computacional y estadística', 'credit' => 3, 'id_modality' => 1, 'id_component' => 6, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190517', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 27, 'name_course' => 'base de datos II', 'credit' => 4, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 5, 'id_course_type' => 2, 'course_code' => '12190518', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 28, 'name_course' => 'complejidad algorítmica', 'credit' => 3, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190519', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 29, 'name_course' => 'desarrollo aplicaciones web', 'credit' => 2, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 5, 'id_course_type' => 2, 'course_code' => '12190520', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 30, 'name_course' => 'ingeniería del software II', 'credit' => 4, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190521', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 31, 'name_course' => 'ingles III', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 5, 'id_course_type' => 1, 'course_code' => '12190522', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 32, 'name_course' => 'análisis numérico', 'credit' => 3, 'id_modality' => 1, 'id_component' => 8, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190622', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 33, 'name_course' => 'arquitectura de sistema operativo', 'credit' => 3, 'id_modality' => 1, 'id_component' => 10, 'id_semester' => 6, 'id_course_type' => 2, 'course_code' => '12190623', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 34, 'name_course' => 'base de datos avanzadas', 'credit' => 2, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 6, 'id_course_type' => 2, 'course_code' => '12190624', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 35, 'name_course' => 'teoría de la computación', 'credit' => 3, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190625', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 36, 'name_course' => 'desarrollo de aplicaciones móviles', 'credit' => 2, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 6, 'id_course_type' => 2, 'course_code' => '12190626', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 37, 'name_course' => 'calidad del software I', 'credit' => 3, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190627', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 38, 'name_course' => 'ingles IV', 'credit' => 2, 'id_modality' => 1, 'id_component' => 3, 'id_semester' => 6, 'id_course_type' => 1, 'course_code' => '12190628', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 39, 'name_course' => 'modelado para la computación', 'credit' => 3, 'id_modality' => 1, 'id_component' => 8, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190728', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 40, 'name_course' => 'redes de computadores', 'credit' => 3, 'id_modality' => 1, 'id_component' => 10, 'id_semester' => 7, 'id_course_type' => 2, 'course_code' => '12190729', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 41, 'name_course' => 'seguridad informática', 'credit' => 3, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190730', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 42, 'name_course' => 'arquitectura de software', 'credit' => 3, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 7, 'id_course_type' => 2, 'course_code' => '12190731', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 43, 'name_course' => 'calidad de software II', 'credit' => 3, 'id_modality' => 1, 'id_component' => 13, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190732', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 44, 'name_course' => 'fundamentos y metodología de la investigación', 'credit' => 2, 'id_modality' => 1, 'id_component' => 2, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190733', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 45, 'name_course' => 'herramientas para pensamiento filosófico', 'credit' => 2, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 7, 'id_course_type' => 1, 'course_code' => '12190734', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 46, 'name_course' => 'gestión de redes', 'credit' => 2, 'id_modality' => 1, 'id_component' => 10, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190833', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 47, 'name_course' => 'sistema de información empresarial', 'credit' => 3, 'id_modality' => 1, 'id_component' => 12, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190834', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 48, 'name_course' => 'electiva I (optativa)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '12190835', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 49, 'name_course' => 'electiva III (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190836', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 50, 'name_course' => 'electiva V (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 8, 'id_course_type' => 2, 'course_code' => '12190837', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 51, 'name_course' => 'creatividad e innovación', 'credit' => 2, 'id_modality' => 1, 'id_component' => 1, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '12190838', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 52, 'name_course' => 'taller de investigación', 'credit' => 2, 'id_modality' => 1, 'id_component' => 2, 'id_semester' => 8, 'id_course_type' => 1, 'course_code' => '12190839', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 53, 'name_course' => 'hci', 'credit' => 2, 'id_modality' => 1, 'id_component' => 11, 'id_semester' => 9, 'id_course_type' => 2, 'course_code' => '12190938', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 54, 'name_course' => 'practica profesional', 'credit' => 2, 'id_modality' => 1, 'id_component' => 14, 'id_semester' => 9, 'id_course_type' => 3, 'course_code' => '12190939', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 55, 'name_course' => 'gestión tecnológica y financiera', 'credit' => 2, 'id_modality' => 1, 'id_component' => 15, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '12190940', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 56, 'name_course' => 'electiva II (optativa)', 'credit' => 2, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '12190941', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 57, 'name_course' => 'electiva IV (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 9, 'id_course_type' => 2, 'course_code' => '12190942', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 58, 'name_course' => 'electiva VI (especializada)', 'credit' => 3, 'id_modality' => 1, 'id_component' => 16, 'id_semester' => 9, 'id_course_type' => 2, 'course_code' => '12190943', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 59, 'name_course' => 'inteligencia social y pensamiento critico', 'credit' => 2, 'id_modality' => 1, 'id_component' => 5, 'id_semester' => 9, 'id_course_type' => 1, 'course_code' => '12190944', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 60, 'name_course' => 'Desarrollo de la Ciencia del Derecho Penal', 'credit' => 3, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150101', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 61, 'name_course' => 'Constitución y Fuentes del Derecho Penal', 'credit' => 2, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150102', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 62, 'name_course' => 'Tipicidad e Imputación Objetiva', 'credit' => 2, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150103', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 63, 'name_course' => 'Antijuricidad y Culpabilidad', 'credit' => 3, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150104', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 64, 'name_course' => 'Sistema de Responsabilidad del Adolescente', 'credit' => 2, 'id_modality' => 1, 'id_component' => null, 'id_semester' => 1, 'id_course_type' => 3, 'course_code' => 'E14150105', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 65, 'name_course' => 'Los Modelos Procesales Penales Nacional e Internacional', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150206', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 66, 'name_course' => 'Las Audiencias y las Formas de Evitacion del Proceso como Estructura de Gestion y Emprendimiento en el Proceso Penal Colombiano', 'credit' => 3, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150207', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 67, 'name_course' => 'La Pena, su Determinacion Legal y Judicial', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150208', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 68, 'name_course' => 'Derecho Internacional Penal', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150209', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 69, 'name_course' => 'Derecho Penal Económico y Globalización', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150210', 'pretential_time' => null, 'independent_time' => null],
            ['id' => 70, 'name_course' => 'Electiva', 'credit' => 2, 'id_modality' => 2, 'id_component' => null, 'id_semester' => 2, 'id_course_type' => 3, 'course_code' => 'E14150211', 'pretential_time' => null, 'independent_time' => null],
        ]);

        // Relacion
        DB::table('programs_courses_relationships')->insert([
            ['id' => 1, 'id_program' => 3, 'id_user' => 6, 'id_course' => 1],
            ['id' => 2, 'id_program' => 3, 'id_user' => 6, 'id_course' => 2],
            ['id' => 3, 'id_program' => 3, 'id_user' => null, 'id_course' => 3],
            ['id' => 4, 'id_program' => 3, 'id_user' => null, 'id_course' => 7],
            ['id' => 5, 'id_program' => 3, 'id_user' => null, 'id_course' => 8],
            ['id' => 6, 'id_program' => 3, 'id_user' => null, 'id_course' => 9],
            ['id' => 7, 'id_program' => 3, 'id_user' => null, 'id_course' => 10],
            ['id' => 8, 'id_program' => 3, 'id_user' => null, 'id_course' => 14],
            ['id' => 9, 'id_program' => 3, 'id_user' => null, 'id_course' => 15],
            ['id' => 10, 'id_program' => 3, 'id_user' => null, 'id_course' => 16],
            ['id' => 11, 'id_program' => 3, 'id_user' => null, 'id_course' => 18],
            ['id' => 12, 'id_program' => 3, 'id_user' => null, 'id_course' => 20],
            ['id' => 13, 'id_program' => 3, 'id_user' => null, 'id_course' => 21],
            ['id' => 14, 'id_program' => 3, 'id_user' => null, 'id_course' => 22],
            ['id' => 15, 'id_program' => 3, 'id_user' => null, 'id_course' => 23],
            ['id' => 16, 'id_program' => 3, 'id_user' => null, 'id_course' => 26],
            ['id' => 17, 'id_program' => 3, 'id_user' => null, 'id_course' => 27],
            ['id' => 18, 'id_program' => 3, 'id_user' => null, 'id_course' => 28],
            ['id' => 19, 'id_program' => 3, 'id_user' => null, 'id_course' => 29],
            ['id' => 20, 'id_program' => 3, 'id_user' => null, 'id_course' => 30],
            ['id' => 21, 'id_program' => 3, 'id_user' => null, 'id_course' => 32],
            ['id' => 22, 'id_program' => 3, 'id_user' => null, 'id_course' => 33],
            ['id' => 23, 'id_program' => 3, 'id_user' => null, 'id_course' => 34],
            ['id' => 24, 'id_program' => 3, 'id_user' => null, 'id_course' => 35],
            ['id' => 25, 'id_program' => 3, 'id_user' => null, 'id_course' => 36],
            ['id' => 26, 'id_program' => 3, 'id_user' => null, 'id_course' => 37],
            ['id' => 27, 'id_program' => 3, 'id_user' => null, 'id_course' => 39],
            ['id' => 28, 'id_program' => 3, 'id_user' => null, 'id_course' => 40],
            ['id' => 29, 'id_program' => 3, 'id_user' => null, 'id_course' => 41],
            ['id' => 30, 'id_program' => 3, 'id_user' => null, 'id_course' => 42],
            ['id' => 31, 'id_program' => 3, 'id_user' => null, 'id_course' => 43],
            ['id' => 32, 'id_program' => 3, 'id_user' => null, 'id_course' => 46],
            ['id' => 33, 'id_program' => 3, 'id_user' => null, 'id_course' => 47],
            ['id' => 34, 'id_program' => 3, 'id_user' => null, 'id_course' => 48],
            ['id' => 35, 'id_program' => 3, 'id_user' => null, 'id_course' => 49],
            ['id' => 36, 'id_program' => 3, 'id_user' => null, 'id_course' => 50],
            ['id' => 37, 'id_program' => 3, 'id_user' => null, 'id_course' => 53],
            ['id' => 38, 'id_program' => 3, 'id_user' => null, 'id_course' => 54],
            ['id' => 39, 'id_program' => 3, 'id_user' => null, 'id_course' => 55],
            ['id' => 40, 'id_program' => 3, 'id_user' => null, 'id_course' => 56],
            ['id' => 41, 'id_program' => 3, 'id_user' => null, 'id_course' => 57],
            ['id' => 42, 'id_program' => 3, 'id_user' => null, 'id_course' => 58],
            ['id' => 43, 'id_program' => null, 'id_user' => null, 'id_course' => 4],
            ['id' => 44, 'id_program' => null, 'id_user' => null, 'id_course' => 5],
            ['id' => 45, 'id_program' => null, 'id_user' => null, 'id_course' => 6],
            ['id' => 46, 'id_program' => null, 'id_user' => null, 'id_course' => 11],
            ['id' => 47, 'id_program' => null, 'id_user' => null, 'id_course' => 12],
            ['id' => 48, 'id_program' => null, 'id_user' => null, 'id_course' => 13],
            ['id' => 49, 'id_program' => null, 'id_user' => null, 'id_course' => 19],
            ['id' => 50, 'id_program' => null, 'id_user' => null, 'id_course' => 24],
            ['id' => 51, 'id_program' => null, 'id_user' => null, 'id_course' => 25],
            ['id' => 52, 'id_program' => null, 'id_user' => null, 'id_course' => 31],
            ['id' => 53, 'id_program' => null, 'id_user' => null, 'id_course' => 38],
            ['id' => 54, 'id_program' => null, 'id_user' => null, 'id_course' => 44],
            ['id' => 55, 'id_program' => null, 'id_user' => null, 'id_course' => 45],
            ['id' => 56, 'id_program' => null, 'id_user' => null, 'id_course' => 51],
            ['id' => 57, 'id_program' => null, 'id_user' => null, 'id_course' => 52],
            ['id' => 58, 'id_program' => null, 'id_user' => null, 'id_course' => 59],
            ['id' => 59, 'id_program' => 13, 'id_user' => null, 'id_course' => 60],
            ['id' => 60, 'id_program' => 13, 'id_user' => 8, 'id_course' => 61],
            ['id' => 61, 'id_program' => 13, 'id_user' => 8, 'id_course' => 62],
            ['id' => 62, 'id_program' => 13, 'id_user' => null, 'id_course' => 63],
            ['id' => 63, 'id_program' => 13, 'id_user' => null, 'id_course' => 64],
            ['id' => 64, 'id_program' => 13, 'id_user' => null, 'id_course' => 65],
            ['id' => 65, 'id_program' => 13, 'id_user' => null, 'id_course' => 66],
            ['id' => 67, 'id_program' => 13, 'id_user' => null, 'id_course' => 67],
            ['id' => 68, 'id_program' => 13, 'id_user' => null, 'id_course' => 68],
            ['id' => 69, 'id_program' => 13, 'id_user' => null, 'id_course' => 69],
            ['id' => 70, 'id_program' => 13, 'id_user' => null, 'id_course' => 70],
            ['id' => 71, 'id_program' => 1, 'id_user' => 7, 'id_course' => 1],
            ['id' => 72, 'id_program' => 1, 'id_user' => 7, 'id_course' => 10],
        ]);

        // Evaluaciones
        DB::table('evaluations')->insert([
            ['id' => 1, 'name_evaluation' => 'taller', 'id_course_type' => 1],
            ['id' => 2, 'name_evaluation' => 'actividad', 'id_course_type' => 2],
            ['id' => 3, 'name_evaluation' => 'quiz', 'id_course_type' => 3],
            ['id' => 4, 'name_evaluation' => 'evaluación', 'id_course_type' => 1],
            ['id' => 5, 'name_evaluation' => 'parcial', 'id_course_type' => 1],
            ['id' => 6, 'name_evaluation' => 'proyecto', 'id_course_type' => 1],
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
