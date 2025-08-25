<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuestraBiologicaController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('muestras')->name('muestras.')->group(function () {
    Route::get('/', [MuestraBiologicaController::class, 'listar'])->name('listar');
    Route::get('/crear', [MuestraBiologicaController::class, 'crear'])->name('crear');
    Route::post('/', [MuestraBiologicaController::class, 'guardar'])->name('guardar');
    Route::get('/{muestra_biologica}/editar', [MuestraBiologicaController::class, 'editar'])->name('editar');
    Route::put('/{muestra_biologica}', [MuestraBiologicaController::class, 'actualizar'])->name('actualizar');
    Route::delete('/{muestra_biologica}', [MuestraBiologicaController::class, 'eliminar'])->name('eliminar');

    Route::get('/inactivos', [MuestraBiologicaController::class, 'inactivos'])->name('inactivos');
    Route::patch('/{id}/restaurar', [MuestraBiologicaController::class, 'restaurar'])->name('restaurar');
    Route::delete('/{id}/destruir', [MuestraBiologicaController::class, 'destruir'])->name('destruir');
});
