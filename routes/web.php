<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\LessonController;
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
    Route::get('/register', 'index')->name('register');
    Route::get('/login', 'index')->name('login');
  });
});
/* -------------------------------- Dashboard ------------------------------- */
Route::view('/dashboard', 'dashboard'/* , ['name' => 'Taylor'] */);

/* ---------------------------------- Class --------------------------------- */
Route::controller(ClassController::class)->group(function () {
  Route::get('/classes/{class_id}', 'index')->name('class_details_page');

  Route::get('/classes/{class_id}/new', 'index')->name('class_creation_page');
  Route::post('/classes/{class_id}', 'index')->name('class_creation');

  Route::get('/classes/{class_id}/edit', 'index')->name('class_modification_page');
  Route::put('/classes/{class_id}', 'index')->name('class_modification');

  Route::delete('/classes/{class_id}', 'index')->name('class_deletion');
});

/* --------------------------------- Lessons -------------------------------- */
Route::controller(LessonController::class)->group(function () {
  /* Dont't think it is necessary */
  // Route::get('/classes/{class_id}/lessons/{lesson_id}', 'index')->name('lesson_details_page');
  Route::get('/classes/{class_id}/lessons/{lesson_id}/new', 'index')->name('lesson_creation_page');
  Route::post('/classes/{class_id}/lessons/{lesson_id}', 'index')->name('lesson_creation');

  Route::get('/classes/{class_id}/lessons/{lesson_id}/edit', 'index')->name('lesson_modification_page');
  Route::put('/classes/{class_id}/lessons/{lesson_id}', 'index')->name('lesson_modification');

  Route::deletion('/classes/{class_id}/lessons/{lesson_id}', 'index')->name('lesson_deletion');
});

/* -------------------------------- Projects -------------------------------- */
Route::controller(LessonController::class)->group(function () {
  Route::get('/classes/{class_id}/lessons/{lesson_id}/projects/{project_id}', 'index')->name('project_details_page'); /* List user uploads for teachers */

  Route::get('/classes/{class_id}/lessons/{lesson_id}/projects/new', 'index')->name('project_creation_page');
  Route::post('/classes/{class_id}/lessons/{lesson_id}/projects', 'index')->name('project_creation_page');

  Route::get('/classes/{class_id}/lessons/{lesson_id}/projects/edit', 'index')->name('project_modification_page');
  Route::put('/classes/{class_id}/lessons/{lesson_id}/projects', 'index')->name('project_modification_page');

  Route::delete('/classes/{class_id}/lessons/{lesson_id}/projects', 'index')->name('project_deletion');
});

/* ------------------------------ User Uploads ------------------------------ */
Route::controller(UploadController::class)->group(function () {
  Route::get('/classes/{class_id}/lessons/{lesson_id}/projects/{project_id}/uploads/{uploads_id}', 'index')->name('upload_details_page');

  Route::get('/classes/{class_id}/lessons/{lesson_id}/projects/{project_id}/uploads/new', 'index')->name('upload_creation_page');
  Route::post('/classes/{class_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_creation_page');

  Route::get('/classes/{class_id}/lessons/{lesson_id}/projects/{project_id}/uploads/edit', 'index')->name('upload_modification_page');
  Route::put('/classes/{class_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_modification_page');

  Route::delete('/classes/{class_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_modification_page');
});

/* -------------------------------- 404 Error ------------------------------- */
Route::fallback(function () {
  //
});