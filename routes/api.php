<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hello', function () {
    return ["message" => "Hello World"];
});

Route::get('/info', function (){
    return response()->json([
        'app' => 'Task Api',
        'version' => '1.0.0',
        'author' => 'Guweh'
    ]);
});

Route::get('/profile', function (){
    return response()->json([
        'name' => 'Guweh',
        'email' => 'adam@example.com',
        'phone' => '08123456789'
    ]);
});

Route::get('/tasks', [TaskController::class, 'index']);

Route::post('/tasks', [TaskController::class, 'store']);

Route::get('/tasks/{id}', [TaskController::class, 'show']);