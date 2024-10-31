<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ClassroomPlanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListClassroomPlanController;
use App\Http\Controllers\ListProfilesCompetenciesRaController;
use App\Http\Controllers\ProfilesCompetenciesRaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListUsersController;
use App\http\Controllers\GenerateDocumentController;
use App\Http\Controllers\ViewProfilesCompetenciesRaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

// Rutas home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas de Create profiles_competencies_ra
Route::get('/profiles-competencies-ra', [ProfilesCompetenciesRaController::class, 'index'])->name('profilesCompetenciesRa');
Route::post('/profiles-competencies-ra/faculty-program', [ProfilesCompetenciesRaController::class, 'filtersFacultyProgram'])->name('filtersFacultyProgram');
Route::post('/profiles-competencies-ra/name-program', [ProfilesCompetenciesRaController::class, 'nameProgram'])->name('nameProgram');
Route::post('/profiles-competencies-ra/save-profile', [ProfilesCompetenciesRaController::class, 'saveProfile'])->name('saveProfile');
Route::post('/profiles-competencies-ra/save-competition', [ProfilesCompetenciesRaController::class, 'saveCompetition'])->name('saveCompetition');
Route::post('/profiles-competencies-ra/save-ra', [ProfilesCompetenciesRaController::class, 'saveRA'])->name('saveRA');

// Rutas de View profiles_competencies_ra
Route::get('/view-profiles-competencies-ra/{id}', [ViewProfilesCompetenciesRaController::class, 'index'])->name('viewProfilesCompetenciesRa');
Route::put('/view-profiles/update-profile', [ViewProfilesCompetenciesRaController::class, 'updateProfile'])->name('updateProfile');

// Rutas de List profiles_competencies_ra
Route::get('/list-profiles-competencies-ra', [ListProfilesCompetenciesRaController::class, 'index'])->name('listProfilesCompetenciesRa');
Route::post('/list-profiles/faculty', [ListProfilesCompetenciesRaController::class, 'listProfiles'])->name('listProfiles');
Route::delete('/list-profiles/delete-profile', [ListProfilesCompetenciesRaController::class, 'deletefiles'])->name('deletefiles');

// Rutas de plan de aula
Route::get('/classroom-plan', [ClassroomPlanController::class, 'index'])->name('classroomPlan');
Route::get('/list-classroom-plan', [ListClassroomPlanController::class, 'index'])->name('listClassroomPlan');
Route::post('/classroom-plan/visualize-info-course', [ClassroomPlanController::class, 'visualizeCourse'])->name('visualizeInfoCourse');
Route::post('/classroom-plan/filters-course', [ClassroomPlanController::class, 'filtersAssignCourse'])->name('filtersAssignCourse');
Route::post('/classroom-plan/list-courses', [ClassroomPlanController::class, 'listCourses'])->name('listCourses');

// Rutas user
Route::get('/user', [UserController::class, 'index'])->name('user');  
Route::post('/user/create', [UserController::class, 'store']);  
Route::get('/user/{id}', [UserController::class, 'show']);  
Route::delete('/user/{id}', [UserController::class, 'destroy']);
Route::patch('/user/{id}', [UserController::class, 'update']);
Route::get('/ListUsers', [ListUsersController::class, 'index'])->name('ListUsers');

//Routes document
Route::get('/document', [GenerateDocumentController::class, 'index'])->name('document');
