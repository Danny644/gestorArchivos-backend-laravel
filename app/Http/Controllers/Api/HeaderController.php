<?php

namespace App\Http\Controllers\Api;

use App\Models\header;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeaderController
{
    public function index(): JsonResponse
    {
        $headers = Header::all();

        if ($headers->isEmpty()) {
            return response()->json([
                'message' => 'No hay headers para mostrar',
                'data' => []
            ], 200);
        }

        return response()->json([
            'message' => 'Headers obtenidos exitosamente',
            'data' => $headers
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'alto' => 'required|numeric',
            'ancho' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $header = Header::create($validator->validated());

        return response()->json([
            'message' => 'Header creado exitosamente',
            'data' => $header
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $header = Header::find($id);

        if (!$header) {
            return response()->json([
                'message' => 'Header no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Header encontrado',
            'data' => $header
        ], 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $header = Header::find($id);

        if (!$header) {
            return response()->json([
                'message' => 'Header no encontrado'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'url' => 'sometimes|string|max:255',
            'alto' => 'sometimes|numeric',
            'ancho' => 'sometimes|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $header->fill($validator->validated());
        $header->save();

        return response()->json([
            'message' => 'Header actualizado exitosamente',
            'data' => $header
        ], 200);
    }

    public function destroy($id): JsonResponse
    {
        $header = Header::find($id);

        if (!$header) {
            return response()->json([
                'message' => 'Header no encontrado'
            ], 404);
        }

        $header->delete();

        return response()->json([
            'message' => 'Header eliminado exitosamente'
        ], 200);
    }
}
