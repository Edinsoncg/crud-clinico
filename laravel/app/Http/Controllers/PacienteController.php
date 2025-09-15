<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\UseCases\Contracts\Pacientes\CrearInterface;
use App\UseCases\Contracts\Pacientes\ActualizarInterface;
use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\UseCases\Contracts\Pacientes\RestaurarInterface;
use App\UseCases\Contracts\Pacientes\EliminarDefinitivoInterface;

class PacienteController extends Controller
{
    public function __construct(private PacienteRepositoryInterface $repo) {}

    public function listar(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $pacientes = $this->repo->listar($perPage);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $pacientes->items(),
                'meta' => [
                    'current_page' => $pacientes->currentPage(),
                    'per_page'     => $pacientes->perPage(),
                    'total'        => $pacientes->total(),
                    'last_page'    => $pacientes->lastPage(),
                ]
            ]);
        }

        // Vista Blade original
        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * OPCIONES para combos (JSON) – útil para SPA/Forms dinámicos
     */
    public function opciones(Request $request)
    {
        // Siempre JSON (endpoint pensado para AJAX)
        return response()->json([
            'tipos_documento' => TipoDocumento::orderBy('nombre')->get(['id', 'nombre']),
            'generos'         => Genero::orderBy('nombre')->get(['id', 'nombre']),
        ]);
    }

    public function crear(Request $request)
    {
        if ($request->wantsJson() || $request->ajax()) {
            // Para SPA: devolvemos opciones + paciente vacío
            return response()->json([
                'paciente'        => new Paciente(),
                'tipos_documento' => TipoDocumento::orderBy('nombre')->get(['id', 'nombre']),
                'generos'         => Genero::orderBy('nombre')->get(['id', 'nombre']),
            ]);
        }

        // Vista Blade original
        return view('pacientes.create', [
            'paciente'        => new Paciente(),
            'tipos_documento' => TipoDocumento::orderBy('nombre')->get(),
            'generos'         => Genero::orderBy('nombre')->get(),
        ]);
    }

    public function guardar(StorePacienteRequest $request, CrearInterface $crear)
    {
        $paciente = $crear->handle($request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Paciente creado correctamente.',
                'data'    => $paciente
            ], 201);
        }

        return redirect()->route('pacientes.listar')->with('success', 'Paciente creado correctamente.');
    }

    public function editar(Request $request, Paciente $paciente)
    {
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data'        => $paciente->load(['tipoDocumento', 'genero']),
                'tipos_documento' => TipoDocumento::orderBy('nombre')->get(['id', 'nombre', 'abreviatura']),
                'generos'         => Genero::orderBy('nombre')->get(['id', 'nombre']),
            ]);
        }

        // Vista Blade original
        return view('pacientes.edit', [
            'paciente'        => $paciente,
            'tipos_documento' => TipoDocumento::orderBy('nombre')->get(),
            'generos'         => Genero::orderBy('nombre')->get(),
        ]);
    }

    public function actualizar(UpdatePacienteRequest $request, Paciente $paciente, ActualizarInterface $actualizar)
    {
        $pacienteActualizado = $actualizar->handle($paciente, $request->validated());

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Paciente actualizado correctamente.',
                'data'    => $pacienteActualizado
            ]);
        }

        return redirect()->route('pacientes.listar')->with('success', 'Paciente actualizado correctamente.');
    }

    public function eliminar(Request $request, Paciente $paciente)
    {
        $ok = $this->repo->eliminar($paciente);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => $ok ? 'Paciente eliminado.' : 'No se pudo eliminar.',
                'ok'      => (bool) $ok
            ], $ok ? 200 : 422);
        }

        return redirect()->route('pacientes.listar')->with('success', 'Paciente eliminado.');
    }

    public function inactivos(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $pacientes = $this->repo->listarEliminadas($perPage);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'data' => $pacientes->items(),
                'meta' => [
                    'current_page' => $pacientes->currentPage(),
                    'per_page'     => $pacientes->perPage(),
                    'total'        => $pacientes->total(),
                    'last_page'    => $pacientes->lastPage(),
                ]
            ]);
        }

        return view('pacientes.inactivos', compact('pacientes'));
    }

    public function restaurar(Request $request, int $id, RestaurarInterface $restaurar)
    {
        $paciente = $this->repo->obtenerEliminadaPorId($id);
        abort_if(!$paciente, 404);

        $restaurado = $restaurar->handle($paciente);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Paciente restaurado.',
                'data'    => $restaurado
            ]);
        }

        return back()->with('success', 'Paciente restaurado.');
    }

    public function destruir(Request $request, int $id, EliminarDefinitivoInterface $eliminar)
    {
        $paciente = $this->repo->obtenerEliminadaPorId($id);
        abort_if(!$paciente, 404);

        $ok = $eliminar->handle($paciente);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => $ok ? 'Paciente eliminado definitivamente.' : 'No se pudo eliminar definitivamente.',
                'ok'      => (bool) $ok
            ], $ok ? 200 : 422);
        }

        return back()->with('success', 'Paciente eliminado definitivamente.');
    }


     //Devuelve solo "data": [] con todas las filas (o página grande).

    public function jsonListadoSimple(Request $request)
    {
        $perPage = (int) $request->input('per_page', 1000);
        $pacientes = $this->repo->listar($perPage);

        return response()->json([
            'data' => $pacientes->items(),
        ]);
    }
}
