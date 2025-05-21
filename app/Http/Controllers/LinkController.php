<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $links = Link::all();
        $linksQuery = Link::where('user_fk', Auth::id());

        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $linksQuery->where(function($q) use ($searchTerm){
                $q->where('source_link', 'like', "%{$searchTerm}%")
                ->orWhere('shortcut_link', 'like', "%{$searchTerm}%");
            });
        }

        $links = $linksQuery->get();

        return view('dashboard', compact('links'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('links.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request)
    {
        $url = config('app.url');
        //$code = Link::generateShortcut();
        
        $code = $request->filled('lienCourte')
        ? $request->input('lienCourte')
        : Link::generateShortcut();
        $shortcut = "$url/".$code;


        // Vérifiez si le même raccourci a déjà été utilisé
        if (Link::where('shortcut_link', $shortcut)->exists()) {
            return back()->withErrors(['shortcut_link' => 'Ce lien court est déjà utilisé.']);
        }

        // Cryptage (facultatif)
        $passwordHash = $request->filled('motDePasse')
        ? Hash::make($request->input('motDePasse'))
        : null;


        $expiresAt = Carbon::now()->addMonth();

        //
        $link = Link::create([
            'source_link' => $request -> lienDeSource,
            'shortcut_link' =>$code,
            'password_protected' => $request->filled('motDePasse'),
            'password_hash' => $passwordHash,
            'user_fk' => Auth::id(),
            'counter' => 0,
            'expires_at' => $expiresAt
        ]);

        return redirect()->route('link.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Link $link)
    {
        //
        return view('links.edit', compact('link'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        //
        $link->update([
            'source_link' => $request->input('lienDeSource'),
            'shortcut_link' => $request->input('lienCourte'),  
        ]);

        return redirect()->route('link.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        //
        $link->delete();

        return redirect()->route('link.index');
    }


    public function redirect(Request $request, $shortcut)
    {
        $link = Link::where('shortcut_link', $shortcut)->first();
         // Redirection
         return redirect()->to($link->source_link, 302); // HTTP 302 Temporary Redirect
    }
}
