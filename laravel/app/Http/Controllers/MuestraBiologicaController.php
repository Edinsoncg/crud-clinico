<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function listar(Request $request)
    {
        $perPage  = (int) $request->input('per_page', 15);
        $muestras = $this->repo->listar($perPage);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data'  => $muestras->items(),
                'meta'  => [
                    'current_page' => $muestras->currentPage(),
                    'per_page'     => $muestras->perPage(),
                    'total'        => $muestras->total(),
                    'last_page'    => $muestras->lastPage(),
                ]
            ]);
        }

        // Vista Blade original
        return view('muestras.index', compact('muestras'));
    }

    /**
     * OPCIONES para combos (JSON) – útil para SPA/Forms dinámicos
     */
    public function opciones(Request $request)
    {
        // Siempre JSON (endpoint pensado para AJAX)
        return response()->json([
            'tipos'     => TipoMuestra::orderBy('nombre')->get(['id','nombre']),
            'estados'   => EstadoMuestra::orderBy('nombre')->get(['id','nombre']),
            'pacientes' => Paciente::orderBy('apellidos')->get(['id','nombres','apellidos']),
            'personal'  => PersonalSalud::orderBy('apellidos')->get(['id','nombres','apellidos']),
        ]);
    }


    public function crear(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            // Para SPA: devolvemos opciones + muestra vacía
            return response()->json([
                'muestra'  => new MuestraBiologica(),
                'tipos'    => TipoMuestra::orderBy('nombre')->get(['id','nombre']),
                'estados'  => EstadoMuestra::orderBy('nombre')->get(['id','nombre']),
                'pacientes'=> Paciente::orderBy('apellidos')->get(['id','nombres','apellidos']),
                'personal' => PersonalSalud::orderBy('apellidos')->get(['id','nombres','apellidos']),
            ]);
        }

        // Vista Blade original
        return view('muestras.create', [
            'muestra'   => new MuestraBiologica(),
            'tipos'     => TipoMuestra::orderBy('nombre')->get(),
            'estados'   => EstadoMuestra::orderBy('nombre')->get(),
            'pacientes' => Paciente::orderBy('apellidos')->get(),
            'personal'  => PersonalSalud::orderBy('apellidos')->get(),
        ]);
    }


    public function guardar(StoreMuestraBiologicaRequest $request, CrearInterface $crear)
    {
        $muestra = $crear->handle($request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Muestra creada correctamente.',
                'data'    => $muestra
            ], 201);
        }

        return redirect()->route('muestras.listar')->with('success', 'Muestra creada correctamente.');
    }


    public function editar(Request $request, MuestraBiologica $muestra_biologica)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'muestra'   => $muestra_biologica->load(['paciente','personalSalud','tipo','estado']),
                'tipos'     => TipoMuestra::orderBy('nombre')->get(['id','nombre']),
                'estados'   => EstadoMuestra::orderBy('nombre')->get(['id','nombre']),
                'pacientes' => Paciente::orderBy('apellidos')->get(['id','nombres','apellidos']),
                'personal'  => PersonalSalud::orderBy('apellidos')->get(['id','nombres','apellidos']),
            ]);
        }

        // Vista Blade original
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
        $muestra = $actualizar->handle($muestra_biologica, $request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Muestra actualizada correctamente.',
                'data'    => $muestra
            ]);
        }

        return redirect()->route('muestras.listar')->with('success', 'Muestra actualizada correctamente.');
    }


    public function eliminar(Request $request, MuestraBiologica $muestra_biologica)
    {
        $ok = $this->repo->eliminar($muestra_biologica);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => $ok ? 'Muestra eliminada.' : 'No se pudo eliminar.',
                'ok'      => (bool) $ok
            ], $ok ? 200 : 422);
        }

        return redirect()->route('muestras.listar')->with('success', 'Muestra eliminada.');
    }


    public function inactivos(Request $request)
    {
        $perPage  = (int) $request->input('per_page', 15);
        $muestras = $this->repo->listarEliminadas($perPage);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $muestras->items(),
                'meta' => [
                    'current_page' => $muestras->currentPage(),
                    'per_page'     => $muestras->perPage(),
                    'total'        => $muestras->total(),
                    'last_page'    => $muestras->lastPage(),
                ]
            ]);
        }

        return view('muestras.inactivos', compact('muestras'));
    }


    public function restaurar(Request $request, int $id, RestaurarInterface $restaurar)
    {
        $muestra = $this->repo->obtenerEliminadaPorId($id);
        abort_if(!$muestra, 404);

        $restaurada = $restaurar->handle($muestra);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Muestra restaurada.',
                'data'    => $restaurada
            ]);
        }

        return back()->with('success', 'Muestra restaurada.');
    }

    public function destruir(Request $request, int $id, EliminarDefinitivoInterface $eliminar)
    {
        $muestra = $this->repo->obtenerEliminadaPorId($id);
        abort_if(!$muestra, 404);

        $ok = $eliminar->handle($muestra);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => $ok ? 'Muestra eliminada definitivamente.' : 'No se pudo eliminar definitivamente.',
                'ok'      => (bool) $ok
            ], $ok ? 200 : 422);
        }

        return back()->with('success', 'Muestra eliminada definitivamente.');
    }

     //Devuelve solo "data": [] con todas las filas (o página grande).

     public function jsonListadoSimple(Request $request)
    {

        $perPage  = (int) $request->input('per_page', 1000);
        $page     = (int) $request->input('page', 1);
        $muestras = $this->repo->listar($perPage);

        return response()->json([
            'data' => $muestras->items(),
        ]);
    }
}
