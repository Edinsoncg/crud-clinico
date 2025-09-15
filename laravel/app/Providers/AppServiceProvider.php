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

        $this->app->bind(
            \App\UseCases\Contracts\MuestrasBiologicas\EliminarDefinitivoInterface::class,
            \App\UseCases\Modules\MuestrasBiologicas\EliminarDefinitivoMuestraBiologica::class
        );

        $this->app->bind(
            \App\UseCases\Contracts\MuestrasBiologicas\RestaurarInterface::class,
            \App\UseCases\Modules\MuestrasBiologicas\RestaurarMuestraBiologica::class
        );

        $this->app->bind(
            \App\Repositories\Contracts\PacienteRepositoryInterface::class,
            \App\Repositories\Modules\PacienteRepository::class
        );
        $this->app->bind(
            \App\UseCases\Contracts\Pacientes\CrearInterface::class,
            \App\UseCases\Modules\Pacientes\CrearPaciente::class
        );
        $this->app->bind(
            \App\UseCases\Contracts\Pacientes\ActualizarInterface::class,
            \App\UseCases\Modules\Pacientes\ActualizarPaciente::class
        );
        $this->app->bind(
            \App\UseCases\Contracts\Pacientes\EliminarDefinitivoInterface::class,
            \App\UseCases\Modules\Pacientes\EliminarDefinitivoPaciente::class
        );
        $this->app->bind(
            \App\UseCases\Contracts\Pacientes\RestaurarInterface::class,
            \App\UseCases\Modules\Pacientes\RestaurarPaciente::class
        );
    }

    public function boot(): void
    {
        // Aquí deja macros, observers, policies… No necesitas bind() aquí.
    }
}
