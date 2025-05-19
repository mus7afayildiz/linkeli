<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                <div class="mb-4 flex justify-between items-center">
                @include('components.search-bar')
                    <h1>Les Liens</h1>
                    <a href="{{ route('links.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
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
                            @foreach($links as $link)
                            <tr>
                                <td>{{ $link->source_link}}</td>
                                <td class="py-4 px-4"><a href="{{ url($link->shortcut_link) }}" target="_blank" rel="noopener noreferrer">{{ url($link->shortcut_link) }}</a></td>
                                <td class="py-4 px-4">{!! QrCode::size(50)->generate($link->shortcut_link) !!}</td>
                                <td>test protégé</td>
                                <td>{{ $link->counter}}</td>
                                <td class="py-4 px-4 md:justify-items-center">
                                    <a href="{{ route('links.edit', $link) }}" class="mr-2 px-3 py-1 bg-yellow-500 text-white text-xs font-medium rounded-lg hover:bg-yellow-600">MODIFIER</a>
                                    <form action="{{ route('links.destroy', $link->link_id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded-lg hover:bg-red-700">SUPPRIMER</a>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                <!-- <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté! Bienvenue sur l'application Linkeli !") }}
                </div> -->

            </div>
        </div>
    </div>
</x-app-layout>
