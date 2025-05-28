<x-guest-layout>
<!--
 ETML
 Auteur      : Mustafa Yildiz
 Date        : 21.05.2025
 Description : La page qui s'ouvre pour permettre à l'utilisateur d'entrer son mot de passe lorsqu'il est dirigé vers des liens protégés par un mot de passe
-->

    <!-- Titre affiché en haut de la page -->
    <x-slot name="header">
        <h2>Mot de passe requis</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">   
                    <!-- Boîte contenant le formulaire --> 
                    <form method="POST" action="{{ route('links.verifyPassword', ['shortcut' => $link->shortcut_link]) }}">
                        @csrf <!-- Protection contre les attaques CSRF -->

                        <!-- Champ de saisie pour le mot de passe -->
                        <div class="mb-4">
                            <label for="password" class="block font-medium text-sm text-gray-700">Entrez le mot de passe</label>
                            <input type="password" name="password" id="password" required class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-900 ">
                            
                            <!-- Affiche un message d'erreur si le mot de passe est incorrect -->
                            @if ($errors->has('password'))
                                <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <!-- Bouton pour envoyer le mot de passe -->
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-200">Accéder au lien</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
