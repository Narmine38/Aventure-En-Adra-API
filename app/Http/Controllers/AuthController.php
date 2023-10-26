<?php

namespace App\Http\Controllers;

// Importation des classes nécessaires.
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Méthode de connexion.
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Invalid credentials.'], 401);
        }

        // Création du token
        $token = $user->createToken('my-app-token')->plainTextToken;

        // Envoyer le token dans un cookie
        $cookie = cookie(
            'laravel_token', // Nom du cookie
            $token,          // Valeur du cookie (le token)
            120,             // Durée en minutes. Adaptez à vos besoins.
            null,
            null,
            true,            // Cookie sécurisé (HTTPS)
            true,            // HttpOnly
            false,
            'none'            // SameSite
        );

        $roles = $user->getRoleNames();

        return response([
            'message' => 'Logged in successfully.',
            'user' => $user,
            'roles' => $roles
        ])->withCookie($cookie);  // Ajoutez le cookie à la réponse
    }


    // Méthode de déconnexion.
    public function logout(Request $request)
    {
        // Vérifie si l'utilisateur est connecté.
        if ($request->user()) {
            // Si l'utilisateur est connecté, supprime le token d'accès actuel.
            $request->user()->currentAccessToken()->delete();
        }

        // Supprime le cookie en le définissant avec une date d'expiration dans le passé.
        $cookie = cookie('laravel_token', '', -60);

        // Renvoie une réponse de déconnexion réussie avec le cookie supprimé.
        return response(['message' => 'Logged out successfully.'])->withCookie($cookie);
    }

}
