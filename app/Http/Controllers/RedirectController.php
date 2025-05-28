<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 13.05.2025
 * Description : Il s’agit du contrôleur créé pour le lien de routage.
 */

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    /**
     * Redirige l'utilisateur vers le lien source.
     * 
     * Description : Cherche le lien avec le raccourci. Si le lien existe et 
     * n'est pas expiré, et n’a pas de mot de passe ou si mot de passe déjà vérifié, 
     * alors redirige vers le lien original.
     * 
     * @param Request $request La requête HTTP
     * @param string $shortcut Le lien court
     * @return RedirectResponse
     */
    public function redirect(Request $request, $shortcut)
    {
        // Nettoyer le raccourci si il y a un point à la fin
        $cleanShortcut = rtrim($shortcut, '.');

         // Chercher le lien dans la base
        $link = Link::where('shortcut_link', $cleanShortcut)->first();

        // Si lien pas trouvé
        if (!$link) {
            abort(404);
        }

        // Contrôle des dates
        if ($link->expires_at && now()->gt($link->expires_at)) {
            return response("Ce lien a expiré.", 403);
        }

        // Si protégé par mot de passe, rediriger vers l'écran de mot de passe
        if ($link->password_protected) {
            return view('links.password', compact('link'));
        }
        
        // Ajouter +1 au compteur de clics
        $link->increment('counter');

        // Redirection
        return redirect()->away($link->source_link, 302);// HTTP 302 Temporary Redirect
    }

    /**
     * Vérifie le mot de passe et redirige si correct.
     * 
     * Description : Après que l’utilisateur entre un mot de passe pour un lien 
     * protégé, ce code vérifie si le mot de passe est correct. Si oui, il redirige.
     * 
     * @param Request $request Les données envoyées avec le formulaire
     * @param string $shortcut Le lien court
     * @return RedirectResponse
     */
    public function verifyPassword(Request $request, $shortcut)
    {
        // Chercher le lien avec le raccourci
        $link = Link::where('shortcut_link', $shortcut)->firstOrFail();

        // Vérifier si le link exist
        if (!$link) {
            abort(404);
        }

         // Vérifier si le mot de passe est correct
        if (!Hash::check($request->input('password'), $link->password_hash)) {
            return redirect()->back()->withErrors(['password' => 'Mot de passe incorrect.'])->withInput();
        }

        // Incrémenter le compteur
        $link->increment('counter');

        // Redirection vers le lien original
        return redirect()->away($link->source_link, 302);
    }
}
