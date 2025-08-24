<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API működik']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('todos', TodoController::class);
});

/*
ez 5 API végpontot hoz létre a Todo erőforráshoz:
GET /api/todos → index()
GET /api/todos/{todo} → show()
POST /api/todos → store()
PUT/PATCH /api/todos/{todo} → update()
DELETE /api/todos/{todo} → destroy()
*/