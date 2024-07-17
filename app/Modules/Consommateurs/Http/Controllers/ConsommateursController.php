<?php

namespace App\Modules\Consommateurs\Http\Controllers;

use App\Modules\Consommateurs\Models\Consommateurs;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class ConsommateursController
{
    /**
     * Récupérer tous les consommateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Consommateurs::all();
    }

    /**
     * Authentifier un consommateur et retourner un token
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    // public function login(Request $request)
    // {
    //     // Validation des données
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required|string',
    //         'password' => 'required|string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'error' => 'Validation error',
    //             'details' => $validator->errors()
    //         ], 400);
    //     }

    //     // Récupération du consommateur
    //     $consommateur = Consommateurs::where('username', $request->username)->first();
    //     if (!$consommateur) {
    //         return response()->json([
    //             'error' => 'Username not found',
    //             'status' => 404,
    //         ], 404);
    //     }

    //     // Vérification du mot de passe
    //     if (!Hash::check($request->password, $consommateur->password)) {
    //         return response()->json([
    //             'error' => 'Incorrect password',
    //             'status' => 401,
    //         ], 401);
    //     }

    //     // Création du token
    //     $token = $consommateur->createToken($consommateur->username)->plainTextToken;
    //     $response = [
    //         'user' => $consommateur,
    //         'token' => $token
    //     ];

    //     return response()->json([
    //         'payload' => $response,
    //         'status' => 200
    //     ]);
    // }

    /**
     * Créer un nouveau consommateur
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:consommateurs,username',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            
            'shift' => 'required|string',
            'fonction' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'details' => $validator->errors()
            ], 400);
        }

        $consommateur = Consommateurs::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
           
            'shift' => $request->shift,
            'fonction' => $request->fonction,
        ]);

        return response()->json($consommateur, 201);
    }

    /**
     * Récupérer les détails d'un consommateur spécifique
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $consommateur = Consommateurs::findOrFail($id);
        return response()->json($consommateur);
    }

    /**
     * Mettre à jour un consommateur spécifique
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'string|unique:consommateurs,username,' . $id,
            'firstname' => 'string',
            'lastname' => 'string',
           
            'shift' => 'string',
            'fonction' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'details' => $validator->errors()
            ], 400);
        }

        $consommateur = Consommateurs::findOrFail($id);
        $consommateur->update([
            'username' => $request->username ?? $consommateur->username,
            'firstname' => $request->firstname ?? $consommateur->firstname,
            'lastname' => $request->lastname ?? $consommateur->lastname,
            'shift' => $request->shift ?? $consommateur->shift,
            'fonction' => $request->fonction ?? $consommateur->fonction,
        ]);

        return response()->json($consommateur, 200);
    }

    /**
     * Supprimer un consommateur spécifique
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $consommateur = Consommateurs::findOrFail($id);
        $consommateur->delete();

        return response()->json(['message' => 'Consommateur deleted'], 200);
    }
}