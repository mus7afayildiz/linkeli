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

        $link->increment('counter');

        // Redirection
        return redirect()->away($link->source_link);// HTTP 302 Temporary Redirect
    }

    public function verifyPassword(Request $request, Link $link)
    {
        return redirect("/{$link->shortcut_link}");
    }
}
