<?php

use App\Http\Controllers\AttributeController;
use App\Http\Controllers\ProjectAttributeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('attributes')->group(function () {
    Route::get('/', [AttributeController::class, 'index']);
    Route::post('/', [AttributeController::class, 'store']);
    Route::put('/{attribute}', [AttributeController::class, 'update']);
});

Route::prefix('projects')->group(function () {
    Route::post('/{project}/attributes', [ProjectAttributeController::class, 'setAttributes']);
    Route::get('/{project}/attributes', [ProjectAttributeController::class, 'getProjectAttributes']);
    Route::get('/filter', [ProjectAttributeController::class, 'filterProjects']);
});