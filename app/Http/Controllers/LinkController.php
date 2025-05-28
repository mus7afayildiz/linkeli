<?php
/**
 * ETML
 * Auteur      : Mustafa Yildiz
 * Date        : 15.05.2025
 * Description : Il s'agit du contrôleur créé pour l'objet Link.
 */

namespace App\Http\Controllers;

use App\Models\Link;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\QRCode as QrCodeModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class LinkController extends Controller
{
    /**
     * Affiche la liste de tous les liens de l'utilisateur connecté.
     */
    public function index(Request $request)
    {
        // Chercher les liens selon utilisateur connecté
        $links = Link::all();
        $linksQuery = Link::where('user_fk', Auth::id());

         // Si un mot est dans la barre de recherche
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $linksQuery->where(function($q) use ($searchTerm){
                $q->where('source_link', 'like', "%{$searchTerm}%")
                ->orWhere('shortcut_link', 'like', "%{$searchTerm}%");
            });
        }

         // Obtenir les liens filtrés
        $links = $linksQuery->get();

        return view('dashboard', compact('links'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau lien.
     */
    public function create()
    {
        //
        return view('links.create');
    }

   /**
     * Enregistre un nouveau lien dans la base de données.
     * 
     * @param StoreLinkRequest $request Les données validées du formulaire
     * @return Redirige vers la liste des liens
     */
    public function store(StoreLinkRequest $request)
    {
        // Obtenir l'URL de base de l'app
        $url = config('app.url');
        
        // Utiliser le lien court donné ou en générer un
        $code = $request->filled('lienCourte')
            ? $request->input('lienCourte')
            : Link::generateShortcut();
            $shortcut = "$url/".$code;


        // Vérifiez si le même raccourci a déjà été utilisé
        if (Link::where('shortcut_link', $code)->exists()) {
            return back()->withErrors(['shortcut_link' => 'Ce lien court est déjà utilisé.']);
        }

        // Créer mot de passe si présent
        $passwordHash = $request->filled('motDePasse')
        ? Hash::make($request->input('motDePasse'))
        : null;

        // La date d’expiration dans 1 mois
        $expiresAt = Carbon::now()->addMonth();

        
        // Créer un nouveau lien dans la base de donnéée
        $link = Link::create([
            'source_link' => $request -> lienDeSource,
            'shortcut_link' =>$code,
            'password_protected' => $request->filled('motDePasse'),
            'password_hash' => $passwordHash,
            'user_fk' => Auth::id(),
            'counter' => 0,
            'expires_at' => $expiresAt
        ]);
        
        //Générer un code QR
        $qrContent = url($link->shortcut_link).".";
        $filename = 'qrcodes/' . Str::uuid() . '.svg';

        $svg = QrCode::format('svg')->size(300)->generate($qrContent);
        Storage::disk('public')->put($filename, $svg);


        // Enregistrer dans la base de données
        QrCodeModel::create([
            'link_id' => $link->link_id,
            'format' => 'svg',
            'chemin_du_fichier' => $filename,
        ]);

        return redirect()->route('link.index');
    }

    /**
     * Affiche un lien (non utilisé ici).
     */
    public function show(Link $link)
    {
        //Non implémenté pour le moment
    }

    /**
     * Affiche le formulaire de modification d’un lien.
     * 
     * @param Link $link Le lien à modifier
     * @return View Le formulaire d'édition
     */
    public function edit(Link $link)
    {
        //
        return view('links.edit', compact('link'));
    }

    /**
     * Met à jour un lien existant.
     * 
     * @param UpdateLinkRequest $request Les données validées
     * @param Link $link Le lien à mettre à jour
     * @return Redirection vers les liens
     */
    public function update(UpdateLinkRequest $request, Link $link)
    {
        // Modifier les infos du lien
        $link->update([
            'source_link' => $request->input('lienDeSource'),
            'shortcut_link' => $request->input('lienCourte'),  
        ]);

        return redirect()->route('link.index');
    }

    /**
     * Supprime un lien.
     * 
     * @param Link $link Le lien à supprimer
     * @return Redirige vers la liste
     */
    public function destroy(Link $link)
    {
        //
        $link->delete();

        return redirect()->route('link.index');
    }


    /**
     * Redirige l'utilisateur vers le lien d'origine.
     * 
     * @param Request $request La requête HTTP
     * @param string $shortcut Le code court
     * @return Redirection vers le lien source
     */
    public function redirect(Request $request, $shortcut)
    {
        $link = Link::where('shortcut_link', $shortcut)->first();
         // Redirection temporaire
         return redirect()->to($link->source_link, 302); 
    }
}
