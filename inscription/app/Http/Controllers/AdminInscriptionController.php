<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminInscriptionController extends Controller
{
    /**
     * Afficher tous les utilisateurs (sans filtrer par statut).
     *
     * @return \Illuminate\View\View
     */
    public function showPending()
    {
        // Récupère tous les utilisateurs
        $users = \App\Models\User::all();
    
        // Récupère tous les rôles disponibles dans la table roles
        $roles = \App\Models\Role::all();
    
        // Renvoie la vue avec les utilisateurs et les rôles
        return view('admin.inscriptions_en_attente', compact('users', 'roles'));
    }

    /**
     * Mettre à jour le statut, le rôle et supprimer les utilisateurs sélectionnés.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateMultiple(Request $request)
    {
        // Récupère les utilisateurs soumis via le formulaire
        $selectedUsers = $request->input('users', []);
    
        foreach ($selectedUsers as $userId => $userData) {
            $user = \App\Models\User::findOrFail($userId);
    
            // Soft delete si le champ delete est défini à 1
            if (isset($userData['delete']) && $userData['delete'] == 1) {
                $user->delete();  // Soft delete
            } else {
                // Mettre à jour le role_id et le statut de l'utilisateur si suppression non demandée
                if (isset($userData['role'])) {
                    $user->role_id = $userData['role'];
                }
                if (isset($userData['statut'])) {
                    $user->statut = $userData['statut'];
                }
                $user->save();
            }
        }
    
        // Redirige avec un message de succès
        return redirect()->back()->with('success', 'Les changements ont été appliqués avec succès !');
    }
    
}
