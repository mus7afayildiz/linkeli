<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Ajouter un nouveau lien') }}
        </h2>
    </x-slot>  

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div>
                    <form method="POST" action="{{ route('links.store')}}" >
                        @csrf
                        <div>
                            <label for="lienDeSource">Lien de Source</label>
                            <input type="text" name="lienDeSource" id="lienDeSource" >
                        </div>

                        <div>
                            <label for="lienCourte">Lien courte personnalisée (Facultatif)</label>
                            <input type="text" name="lienCourte" id="lienCourte" >
                        </div>

                        <div>
                            <label for="motDePasse">Mot de Passe</label>
                            <input type="password" name="motDePasse" id="motDePasse" >
                        </div>

                        <div>
                            <label for="confirmationMotDePasse">Confirmez le mot de passe</label>
                            <input type="password" name="confirmationMotDePasse" id="confirmationMotDePasse" >
                        </div>

        
                        <div class="mt-4">
                            <button type="submit" class="bg-indigo-600 text-white">
                                SAUVEGARDER
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>