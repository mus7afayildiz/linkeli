<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        //
        $link = Link::create([
            'source_link' => $request -> lienDeSource,
            'shortcut_link' => $request -> lienCourte,
            'user_fk' => Auth::id(),
            'counter' => 0
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
}
