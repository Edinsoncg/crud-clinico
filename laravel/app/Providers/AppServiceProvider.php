<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registrar servicios y bindings del contenedor.
     */
    public function register(): void
    {
        // Repositorio de Muestras Biológicas
        $this->app->bind(
            \App\Repositories\Contracts\MuestraBiologicaRepositoryInterface::class,
            \App\Repositories\Modules\MuestraBiologicaRepository::class
        );

        // Use cases de Muestras Biológicas
        $this->app->bind(
            \App\UseCases\Contracts\MuestrasBiologicas\CrearInterface::class,
            \App\UseCases\Modules\MuestrasBiologicas\CrearMuestraBiologica::class
        );

        $this->app->bind(
            \App\UseCases\Contracts\MuestrasBiologicas\ActualizarInterface::class,
            \App\UseCases\Modules\MuestrasBiologicas\ActualizarMuestraBiologica::class
        );

        // (Opcional) Agrega aquí futuros binds de Pacientes, Personal, etc.
        /*
        $this->app->bind(
            \App\Repositories\Contracts\PacienteRepositoryInterface::class,
            \App\Repositories\Eloquent\EloquentPacienteRepository::class
        );
        $this->app->bind(
            \App\UseCases\Contracts\Pacientes\CreateInterface::class,
            \App\UseCases\Pacientes\CrearPaciente::class
        );
        */
    }

    public function boot(): void
    {
        // Aquí deja macros, observers, policies… No necesitas bind() aquí.
    }
}
