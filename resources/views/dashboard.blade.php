<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                
                <div class="mb-4 flex justify-between items-center">
                    <h3>Les Liens</h3>
                    <a href="{{ route('links.create') }}" class="bg-blue-600 text-white ">
                        + AJOUTER UN NOUVEAU LIEN
                    </a>
                </div>    
                <div>
                    <table>
                        <thead>
                            <tr>
                                <th>Lien de Source</th>
                                <th>Lien de Raccourci</th>
                                <th>QRCode</th>
                                <th>Protégé</th>
                                <th>Compteur</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>test lien de source</td>
                                <td>test lien de raccourci</td>
                                <td>test qr code</td>
                                <td>test protégé</td>
                                <td>test compteur</td>
                                <td>
                                    <a href="{{ route('links.edit') }}">MODIFIER</a>
                                    <a href="">SUPPRIMER</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            
                <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté! Bienvenue sur l'application Linkeli !") }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
