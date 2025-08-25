<?php

namespace App\Http\Controllers;

use App\Models\TipoMuestra;
use App\Models\EstadoMuestra;
use App\Models\Paciente;
use App\Models\PersonalSalud;
use App\Models\MuestraBiologica;
use App\Repositories\Contracts\MuestraBiologicaRepositoryInterface;
use App\UseCases\Contracts\MuestrasBiologicas\CrearInterface;
use App\UseCases\Contracts\MuestrasBiologicas\ActualizarInterface;
use App\Http\Requests\StoreMuestraBiologicaRequest;
use App\Http\Requests\UpdateMuestraBiologicaRequest;
use App\UseCases\Contracts\MuestrasBiologicas\RestaurarInterface;
use App\UseCases\Contracts\MuestrasBiologicas\EliminarDefinitivoInterface;

class MuestraBiologicaController extends Controller
{
    public function __construct(private MuestraBiologicaRepositoryInterface $repo) {}

    public function listar()
    {
        $muestras = $this->repo->listar(15);
        return view('muestras.index', compact('muestras'));
    }

    public function crear()
    {
        return view('muestras.create', [
            'muestra'   => new \App\Models\MuestraBiologica(),
            'tipos'      => TipoMuestra::orderBy('nombre')->get(),
            'estados'    => EstadoMuestra::orderBy('nombre')->get(),
            'pacientes'  => Paciente::orderBy('apellidos')->get(),
            'personal'   => PersonalSalud::orderBy('apellidos')->get(),
        ]);
    }

    public function guardar(StoreMuestraBiologicaRequest $request, CrearInterface $crear)
    {
        $crear->handle($request->validated());
        return redirect()->route('muestras.listar')->with('success', 'Muestra creada correctamente.');
    }

    public function editar(MuestraBiologica $muestra_biologica)
    {
        return view('muestras.edit', [
            'muestra'   => $muestra_biologica,
            'tipos'     => TipoMuestra::orderBy('nombre')->get(),
            'estados'   => EstadoMuestra::orderBy('nombre')->get(),
            'pacientes' => Paciente::orderBy('apellidos')->get(),
            'personal'  => PersonalSalud::orderBy('apellidos')->get(),
        ]);
    }

    public function actualizar(UpdateMuestraBiologicaRequest $request, MuestraBiologica $muestra_biologica, ActualizarInterface $actualizar)
    {
        $actualizar->handle($muestra_biologica, $request->validated());
        return redirect()->route('muestras.listar')->with('success', 'Muestra actualizada correctamente.');
    }

    public function eliminar(MuestraBiologica $muestra_biologica)
    {
        $this->repo->eliminar($muestra_biologica);
        return redirect()->route('muestras.listar')->with('success', 'Muestra eliminada.');
    }


    // NUEVO: listar inactivos
    public function inactivos()
    {
        $muestras = $this->repo->listarEliminadas(15);
        return view('muestras.inactivos', compact('muestras'));
    }

    // NUEVO: restaurar
    public function restaurar(int $id, RestaurarInterface $restaurar)
    {
        $muestras = $this->repo->obtenerEliminadaPorId($id);
        abort_if(!$muestras, 404);
        $restaurar->handle($muestras);

        return back()->with('success', 'Muestra restaurada.');
    }

    // NUEVO: eliminar definitivamente
    public function destruir(int $id, EliminarDefinitivoInterface $eliminar)
    {
        $muestras = $this->repo->obtenerEliminadaPorId($id);
        abort_if(!$muestras, 404);
        $eliminar->handle($muestras);

        return back()->with('success', 'Muestra eliminada definitivamente.');
    }
}
