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
  Route::get('/courses', 'index')->name('courses_list_page');
  Route::get('/courses/create', 'create')->name('course_creation_page');
  Route::get('/courses/{course_id}/edit', 'edit')->name('course_modification_page');
  Route::get('/courses/{course_id}', 'show')->name('course_details_page');

  Route::post('/courses', 'store')->name('course_creation');
  Route::put('/courses/{course_id}', 'update')->name('course_modification');
  Route::delete('/courses/{course_id}', 'destroy')->name('course_deletion');

  Route::get('/courses/{course_id}/users', 'getUsers')->name('course_users_page');
  Route::post('/courses/{course_id}/users', 'linkUser')->name('course_link_users');
  Route::put('/courses/{course_id}/users/{user_id}', 'unlinkUser')->name('course_unlink_users');
});

/* --------------------------------- Lessons -------------------------------- */
Route::controller(LessonController::class)->group(function () {
  /* Dont't think it is necessary */
  // Route::get('/courses/{course_id}/lessons/{lesson_id}', 'show')->name('lesson_details_page');
  Route::get('/courses/{course_id}/lessons/create', 'create')->name('lesson_creation_page');
  Route::get('/courses/{course_id}/lessons/{lesson_id}/edit', 'edit')->name('lesson_modification_page');

  Route::post('/courses/{course_id}/lessons', 'store')->name('lesson_creation');
  Route::put('/courses/{course_id}/lessons/{lesson_id}', 'update')->name('lesson_modification');
  Route::delete('/courses/{course_id}/lessons/{lesson_id}', 'destroy')->name('lesson_deletion');
});

/* -------------------------------- Projects -------------------------------- */
Route::controller(ProjectController::class)->group(function () {
  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/users', 'getUsers')->name('project_users_page');
  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/create', 'create')->name('project_creation_page');
  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/edit', 'edit')->name('project_modification_page');
  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}', 'show')->name('project_details_page'); /* List user uploads for teachers */

  Route::post('/courses/{course_id}/lessons/{lesson_id}/projects', 'store')->name('project_creation');
  Route::put('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}', 'update')->name('project_modification');
  Route::delete('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}', 'destroy')->name('project_deletion');
});

/* ---------------------------------- Users --------------------------------- */
Route::controller(UserController::class)->group(function () {
  // TODO: See if it is okay to add a user profile to edit his own data
  // Route::get('/users/{user_id}/edit', 'edit')->name('user_modification_page');
  // TODO: See if it is okay to add page to see user details (for himself and the teachers)
  // Route::get('/users/{user_id}', 'show')->name('user_details_page');

  // Route::put('/users/{user_id}', 'update')->name('user_modification');
  // TODO: See if it is okay to add a deletetion button to the user profile to delete the account (Just 'admin' can delete)
  // Route::delete('/users/{user_id}', 'destroy')->name('user_deletion');
});

/* ------------------------------ User Uploads ------------------------------ */
Route::controller(UploadController::class)->group(function () {
  // Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/{uploads_id}', 'index')->name('upload_details_page');
  Route::post('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/{file_id}/download', 'download_file')->name('upload_file_download');
  Route::delete('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/{document_id}', 'destroy')->name('upload_deletion');

  /* --------------------------------- General -------------------------------- */
  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/create', 'index')->name('upload_creation_page');
  Route::post('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'store')->name('upload_creation');

  Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/edit', 'index')->name('upload_modification_page');
  Route::put('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_modification');

  Route::delete('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads', 'index')->name('upload_modification_page');
});

/* -------------------------------- 404 Error ------------------------------- */
Route::fallback(function () {
  //
});