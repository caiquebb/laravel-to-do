<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoItemController;
use App\Http\Controllers\TodoTodoItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResources([
        'users' => UserController::class,
        'todos' => TodoController::class,
        'todo-items' => TodoItemController::class,
        'users.todos' => UserTodoController::class,
        'todos.todo-items' => TodoTodoItemController::class,
    ]);

    Route::prefix('/todos/{id}')->group(function () {
        Route::post('/restore', [TodoController::class, 'restore']);
        Route::delete('/force', [TodoController::class, 'forceDelete']);
    });
});
