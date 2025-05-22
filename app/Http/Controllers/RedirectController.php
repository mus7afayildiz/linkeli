<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RedirectController extends Controller
{
    public function redirect(Request $request, $shortcut)
    {

        $link = Link::where('shortcut_link', $shortcut)->first();

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
        
        $link->increment('counter');

        // Redirection
        return redirect()->away($link->source_link, 302);// HTTP 302 Temporary Redirect
    }

    public function verifyPassword(Request $request, $shortcut)
    {
        $link = Link::where('shortcut_link', $shortcut)->first();

        if (!$link) {
            abort(404);
        }

        if (!Hash::check($request->input('password'), $link->password_hash)) {
            return back()->withErrors(['password' => 'Mot de passe incorrect.']);
        }

        $link->increment('counter');

        return redirect()->away($link->source_link, 302);
    }
}
