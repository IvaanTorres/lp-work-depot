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
  Route::prefix('/auth')->group(function () {
    Route::get('/register', 'show_register')->name('register_page');
    Route::post('/register', 'register')->name('register');
    Route::get('/login', 'show_login')->name('login_page');
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
  });
});

/* ---------------------------------- Course --------------------------------- */
Route::controller(CourseController::class)->group(function () {
  Route::prefix('/courses')->group(function () {
    Route::get('/', 'index')->name('courses_list_page');
    Route::get('/create', 'create')->name('course_creation_page');
    Route::get('/{course_id}/edit', 'edit')->name('course_modification_page');
    Route::get('/{course_id}', 'show')->name('course_details_page');

    Route::post('/', 'store')->name('course_creation');
    Route::put('/{course_id}', 'update')->name('course_modification');
    Route::delete('/{course_id}', 'destroy')->name('course_deletion');

    Route::get('/{course_id}/users', 'getUsers')->name('course_users_page');
    Route::post('/{course_id}/users', 'linkUser')->name('course_link_users');
    Route::put('/{course_id}/users/{user_id}', 'unlinkUser')->name('course_unlink_users');
  });
});

/* --------------------------------- Lessons -------------------------------- */
Route::controller(LessonController::class)->group(function () {
  Route::prefix('/courses/{course_id}/lessons')->group(function () {
    Route::get('/{lesson_id}/edit', 'edit')->name('lesson_modification_page');
    Route::get('/create', 'create')->name('lesson_creation_page');

    Route::post('/', 'store')->name('lesson_creation');
    Route::put('/{lesson_id}', 'update')->name('lesson_modification');
    Route::delete('/{lesson_id}', 'destroy')->name('lesson_deletion');
  });
});

/* -------------------------------- Projects -------------------------------- */
Route::controller(ProjectController::class)->group(function () {
  Route::prefix('/courses/{course_id}/lessons/{lesson_id}/projects')->group(function () {
    Route::get('/{project_id}/users/', 'getUsers')->name('project_users_page');
    Route::get('/{project_id}/users/{user_id}', 'getUserDetails')->name('project_user_details_page');
    Route::put('/{project_id}/users/{user_id}', 'evaluate')->name('project_evaluate');

    Route::get('/create', 'create')->name('project_creation_page');
    Route::get('/{project_id}/edit', 'edit')->name('project_modification_page');
    Route::get('/{project_id}', 'show')->name('project_details_page'); /* List user uploads for teachers */

    Route::post('/', 'store')->name('project_creation');
    Route::put('/{project_id}', 'update')->name('project_modification');
    Route::delete('/{project_id}', 'destroy')->name('project_deletion');
  });
});

/* ------------------------------ User Uploads ------------------------------ */
Route::controller(UploadController::class)->group(function () {
  Route::prefix('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads')->group(function () {
    // Route::get('/courses/{course_id}/lessons/{lesson_id}/projects/{project_id}/uploads/{uploads_id}', 'index')->name('upload_details_page');
    Route::post('/{file_id}/download', 'download_file')->name('upload_file_download');
    Route::delete('/{document_id}', 'destroy')->name('upload_deletion');

    Route::get('/create', 'index')->name('upload_creation_page');
    Route::post('/', 'store')->name('upload_creation');

    Route::get('/edit', 'index')->name('upload_modification_page');
    Route::put('/', 'index')->name('upload_modification');
  });
});

/* -------------------------------- 404 Error ------------------------------- */
Route::fallback(function () {
  return view('404');
});