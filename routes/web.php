<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* ----------------------------- User Controller ---------------------------- */
Route::controller(UserController::class)->group(function () {
  /* Auth */
  Route::prefix('auth')->group(function () {
    Route::get('/register', 'show_register')->name('register_page');
    Route::post('/register', 'register')->name('register');
    Route::get('/login', 'show_login')->name('login_page');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
  });
});
/* -------------------------------- Dashboard ------------------------------- */
// Route::view('/dashboard', 'dashboard.index')
//   ->middleware(['roles:student', 'auth'])
//   ->name('dashboard_page');

/* ---------------------------------- Course --------------------------------- */
Route::controller(CourseController::class)->group(function () {
  Route::get('/courses', 'index')->name('course_list_page');
  Route::get('/courses/{course_id}', 'show')->name('course_details_page');

  Route::get('/courses/{course_id}/create', 'create')->name('course_creation_page');
  Route::post('/courses/{course_id}', 'store')->name('course_creation');

  Route::get('/courses/{course_id}/edit', 'edit')->name('course_modification_page');
  Route::put('/courses/{course_id}', 'update')->name('course_modification');

  Route::delete('/courses/{course_id}', 'destroy')->name('course_deletion');
});

/* --------------------------------- Lessons -------------------------------- */
Route::controller(LessonController::class)->group(function () {
  /* Dont't think it is necessary */
  Route::get('/courses/{course_id}/lessons/{lesson_id}', 'show')->name('lesson_details_page');

  Route::get('/courses/{course_id}/lessons/{lesson_id}/create', 'create')->name('lesson_creation_page');
  Route::post('/courses/{course_id}/lessons/{lesson_id}', 'store')->name('lesson_creation');

  Route::get('/courses/{course_id}/lessons/{lesson_id}/edit', 'edit')->name('lesson_modification_page');
  Route::put('/courses/{course_id}/lessons/{lesson_id}', 'update')->name('lesson_modification');

  Route::delete('/courses/{course_id}/lessons/{lesson_id}', 'destroy')->name('lesson_deletion');
});

/* -------------------------------- Projects -------------------------------- */
Route::controller(ProjectController::class)->group(function () {
  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}', 'index')->name('project_details_page'); /* List user uploads for teachers */

  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/create', 'index')->name('project_creation_page');
  Route::post('/courses/{course_id}/lessons/{lesson_id}/projects', 'index')->name('project_creation_page');

  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/edit', 'index')->name('project_modification_page');
  Route::put('/courses/{course_id}/lessons/{lesson_id}/projects', 'index')->name('project_modification_page');

  Route::delete('/courses/{course_id}/lessons/{lesson_id}/projects', 'index')->name('project_deletion');
});

/* ------------------------------ User Uploads ------------------------------ */
Route::controller(UploadController::class)->group(function () {
  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/{uploads_id}', 'index')->name('upload_details_page');

  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/create', 'index')->name('upload_creation_page');
  Route::post('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_creation_page');

  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/edit', 'index')->name('upload_modification_page');
  Route::put('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_modification_page');

  Route::delete('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_modification_page');
});

/* -------------------------------- 404 Error ------------------------------- */
Route::fallback(function () {
  //
});