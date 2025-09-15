<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MuestraBiologicaController;
use App\Http\Controllers\PacienteController;

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

    // Inactivos
    Route::get('/inactivos', [MuestraBiologicaController::class, 'inactivos'])->name('inactivos');
    Route::patch('/{id}/restaurar', [MuestraBiologicaController::class, 'restaurar'])->name('restaurar');
    Route::delete('/{id}/destruir', [MuestraBiologicaController::class, 'destruir'])->name('destruir');

    // NUEVOS para SPA/DataTables/Selects
    Route::get('/opciones/json', [MuestraBiologicaController::class, 'opciones'])->name('opciones.json');
    Route::get('/listado/json',  [MuestraBiologicaController::class, 'jsonListadoSimple'])->name('listado.json');
});

Route::prefix('pacientes')->name('pacientes.')->group(function () {

    Route::get('/', [PacienteController::class, 'listar'])->name('listar');
    Route::get('/crear', [PacienteController::class, 'crear'])->name('crear');
    Route::post('/', [PacienteController::class, 'guardar'])->name('guardar');
    Route::get('/{paciente}/editar', [PacienteController::class, 'editar'])->name('editar');
    Route::put('/{paciente}', [PacienteController::class, 'actualizar'])->name('actualizar');
    Route::delete('/{paciente}', [PacienteController::class, 'eliminar'])->name('eliminar');

    // Inactivos
    Route::get('/inactivos', [PacienteController::class, 'inactivos'])->name('inactivos');
    Route::patch('/{id}/restaurar', [PacienteController::class, 'restaurar'])->name('restaurar');
    Route::delete('/{id}/destruir', [PacienteController::class, 'destruir'])->name('destruir');

    // NUEVOS para SPA/DataTables/Selects
    Route::get('/opciones/json', [PacienteController::class, 'opciones'])->name('opciones.json');
    Route::get('/listado/json',  [PacienteController::class, 'jsonListadoSimple'])->name('listado.json');
});
