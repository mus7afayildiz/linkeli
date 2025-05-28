<x-app-layout>
<!--
 ETML
 Auteur      : Mustafa Yildiz
 Date        : 14.05.2025
 Description : La page qui s'ouvre pour permettre à l'utilisateur de créer un lien.
-->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Ajouter un nouveau lien') }}
        </h2>
    </x-slot>  

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">

                <div class="p-6 text-gray-900 space-y-6">
                    <!-- Formulaire pour ajouter un lien -->
                    <form method="POST" action="{{ route('links.store')}}" >
                    <!-- Affiche les erreurs de validation -->
                    @if ($errors->any())
                        <div class="mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf <!-- Token de sécurité -->

                        <!-- Champ pour le lien de destination -->
                        <div>
                            <label for="lienDeSource" class="block font-medium text-sm text-gray-700">Lien de Source</label>
                            <input type="text" name="lienDeSource" id="lienDeSource" class="w-full mt-1 px-3 py-2 border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-900">
                        </div>

                        <!-- Champ optionnel pour le lien court personnalisé -->
                        <div>
                            <label for="lienCourte" class="mt-3 block font-medium text-sm text-gray-700">Lien courte personnalisée (Facultatif)</label>
                            <input type="text" name="lienCourte" id="lienCourte" class="w-full mt-1 px-3 py-2 border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-900">
                        </div>

                         <!-- Champ pour entrer un mot de passe -->
                        <div>
                            <label for="motDePasse" class="mt-3 block font-medium text-sm text-gray-700">Mot de Passe</label>
                            <input type="password" name="motDePasse" id="motDePasse" class="w-full mt-1 px-3 py-2 border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-900">
                        </div>
                        <!-- Champ pour confirmer le mot de passe -->
                        <div>
                            <label for="confirmationMotDePasse" class="mt-3 block font-medium text-sm text-gray-700">Confirmez le mot de passe</label>
                            <input type="password" name="confirmationMotDePasse" id="confirmationMotDePasse" class="w-full mt-1 px-3 py-2 border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-900">
                        </div>

                        <!-- Bouton pour envoyer le formulaire -->
                        <div class="mt-4">
                            <button type="submit" class="mt-3 w-full px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-200">
                                SAUVEGARDER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>