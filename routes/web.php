<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ClassroomPlanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListClassroomPlanController;
use App\Http\Controllers\ListProfilesCompetenciesRaController;
use App\Http\Controllers\ProfilesCompetenciesRaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListUsersController;
use App\http\Controllers\GenerateDocumentController;
use App\Http\Controllers\ViewClassroomPlanController;
use App\Http\Controllers\ViewProfilesCompetenciesRaController;
use App\http\Controllers\FacultiController;


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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Rutas de Create profiles_competencies_ra
    Route::get('/profiles-competencies-ra', [ProfilesCompetenciesRaController::class, 'index'])->name('profilesCompetenciesRa');
    Route::post('/profiles-competencies-ra/validate-profile', [ProfilesCompetenciesRaController::class, 'validateProfile'])->name('validateProfile');
    Route::post('/profiles-competencies-ra/faculty-program', [ProfilesCompetenciesRaController::class, 'filtersFacultyProgram'])->name('filtersFacultyProgram');
    Route::post('/profiles-competencies-ra/name-program', [ProfilesCompetenciesRaController::class, 'nameProgram'])->name('nameProgram');
    Route::post('/profiles-competencies-ra/save-profile', [ProfilesCompetenciesRaController::class, 'saveProfile'])->name('saveProfile');
    Route::put('/profiles-competencies-ra/save-competition', [ProfilesCompetenciesRaController::class, 'saveCompetition'])->name('saveCompetition');
    Route::put('/profiles-competencies-ra/save-ra', [ProfilesCompetenciesRaController::class, 'saveRA'])->name('saveRA');

    // Rutas de View profiles_competencies_ra
    Route::get('/view-profiles-competencies-ra/{id}', [ViewProfilesCompetenciesRaController::class, 'index'])->name('viewProfilesCompetenciesRa');
    Route::post('/view-profiles-competencies-ra/search-program-faculty', [ViewProfilesCompetenciesRaController::class, 'programFaculty'])->name('programFaculty');
    Route::put('/view-profiles/update-profile', [ViewProfilesCompetenciesRaController::class, 'updateProfile'])->name('updateProfile');

    // Rutas de List profiles_competencies_ra
    Route::get('/list-profiles-competencies-ra', [ListProfilesCompetenciesRaController::class, 'index'])->name('listProfilesCompetenciesRa');
    Route::post('/list-profiles/faculty', [ListProfilesCompetenciesRaController::class, 'listProfiles'])->name('listProfiles');
    Route::delete('/list-profiles/delete-profile', [ListProfilesCompetenciesRaController::class, 'deletefiles'])->name('deletefiles');

    // Rutas de plan de aula
    Route::get('/classroom-plan', [ClassroomPlanController::class, 'index'])->name('classroomPlan');
    Route::post('/classroom-plan/search-program', [ClassroomPlanController::class, 'searchProgram'])->name('searchProgram');
    Route::post('/classroom-plan/search-course', [ClassroomPlanController::class, 'searchCourses'])->name('searchCourses');
    Route::get('/classroom-plan/search-study-field', [ClassroomPlanController::class, 'searchStudyField'])->name('searchStudyField');
    Route::post('/classroom-plan/search-info-course', [ClassroomPlanController::class, 'viewInfoCourse'])->name('viewInfoCourse');
    Route::post('/classroom-plan/search-list-courses', [ClassroomPlanController::class, 'viewListCourses'])->name('viewListCourses');
    Route::post('/classroom-plan/search-classroom-plans', [ClassroomPlanController::class, 'searchClassroomPlan'])->name('searchClassroomPlan');
    Route::post('/classroom-plan/search-learning', [ClassroomPlanController::class, 'searchLearning'])->name('searchLearning');
    Route::post('/classroom-plan/search-description-Learning', [ClassroomPlanController::class, 'searchDescriptionLearning'])->name('searchDescriptionLearning');
    Route::post('/classroom-plan/create-classroom-plans', [ClassroomPlanController::class, 'createClassroomPlan'])->name('createClassroomPlan');
    Route::put('/classroom-plan/save-general-objective', [ClassroomPlanController::class, 'createObjectiveGeneral'])->name('createObjectiveGeneral');
    Route::put('/classroom-plan/save-specific-objective', [ClassroomPlanController::class, 'createObjectiveSpecific'])->name('createObjectiveSpecific');
    Route::put('/classroom-plan/save-topic', [ClassroomPlanController::class, 'createTopics'])->name('createTopics');
    Route::put('/classroom-plan/save-evaluations', [ClassroomPlanController::class, 'createEvaluations'])->name('createEvaluations');
    Route::put('/classroom-plan/save-references', [ClassroomPlanController::class, 'createReferences'])->name('createReferences');

    // Rutas de listado de plan de aula
    Route::get('/list-classroom-plan', [ListClassroomPlanController::class, 'index'])->name('listClassroomPlan');
    Route::get('/list-classroom-plan/search-faculty', [ListClassroomPlanController::class, 'searchFaculty'])->name('searchFaculty');
    Route::post('/list-classroom-plan/search-program', [ListClassroomPlanController::class, 'searchProgram'])->name('searchProgram');
    Route::post('/list-classroom-plan/search-campo-comun', [ListClassroomPlanController::class, 'searchCampoComun'])->name('searchCampoComun');
    Route::post('/list-classroom-plan/search-classroom-plan', [ListClassroomPlanController::class, 'searchClassroomPlan'])->name('searchClassroomPlan');

    // Rutas de vizualizacion de plan de aula
    Route::get('/view-classroom-plan/{id}', [ViewClassroomPlanController::class, 'index'])->name('viewClassroomPlan');
    Route::post('/view-classroom-plan/info-classroom-plans', [ViewClassroomPlanController::class, 'ClaassroomInfo'])->name('ClaassroomInfo');
    Route::post('/view-classroom-plan/search-data', [ViewClassroomPlanController::class, 'searchData'])->name('searchData');

    // Rutas user
    Route::get('/user', [UserController::class, 'index'])->name('user');
    Route::post('/user/create', [UserController::class, 'store']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
    Route::patch('/user/{id}', [UserController::class, 'update']);
    Route::get('/ListUsers', [ListUsersController::class, 'index'])->name('ListUsers');

//Rutas para facultedes
Route::get('/plan-aula', [FacultiController::class,'index'])->name('faculties');
Route::get('/plan-aula/donwload', [FacultiController::class,'export'])->name('export');
Route::get('/plan-aula/pdf', [FacultiController::class,'pdfPlanAula'])->name('pdfplan');
//Routes document
Route::get('/document', [GenerateDocumentController::class, 'index'])->name('document');
});

require __DIR__ . '/auth.php';
