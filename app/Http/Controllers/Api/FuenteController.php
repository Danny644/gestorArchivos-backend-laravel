<?php

namespace App\Http\Controllers\Api;

use App\Models\Fuente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FuenteController
{
    public function index(): JsonResponse
    {
        $fuentes = Fuente::all();

        if ($fuentes->isEmpty()) {
            return response()->json([
                'message' => 'No hay fuentes para mostrar',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Fuentes obtenidas exitosamente',
            'data' => $fuentes
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $fuente = Fuente::create($validator->validated());

        return response()->json([
            'message' => 'Fuente creada exitosamente',
            'data' => $fuente
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $fuente = Fuente::find($id);

        if (!$fuente) {
            return response()->json([
                'message' => 'Fuente no encontrada'
            ], 404);
        }

        return response()->json([
            'message' => 'Fuente encontrada',
            'data' => $fuente
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $fuente = Fuente::find($id);

        if (!$fuente) {
            return response()->json([
                'message' => 'Fuente no encontrada'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $fuente->fill($validator->validated());
        $fuente->save();

        return response()->json([
            'message' => 'Fuente actualizada exitosamente',
            'data' => $fuente
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $fuente = Fuente::find($id);

        if (!$fuente) {
            return response()->json([
                'message' => 'Fuente no encontrada'
            ], 404);
        }

        $fuente->delete();

        return response()->json([
            'message' => 'Fuente eliminada exitosamente'
        ], 200);
    }
}
