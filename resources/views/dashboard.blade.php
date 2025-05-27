<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                
                <div class="mb-6 flex justify-between">
                @include('components.search-bar')
                   
                    <a href="{{ route('links.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        + AJOUTER UN NOUVEAU LIEN
                    </a>
                </div>    
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-200 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lien de Destination </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lien de Raccourci</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">QRCode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lien de QRCode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Protégé</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compteur</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($links as $link)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 break-words max-w-xs">{{ $link->source_link}}</td>
                                <td class="px-6 py-4 text-sm text-gray-900"><a href="{{ url($link->shortcut_link) }}" target="_blank" rel="noopener noreferrer">{{ url($link->shortcut_link) }}</a></td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @if($link->qrCode)
                                        <img src="{{ asset('storage/' . $link->qrCode->chemin_du_fichier) }}" alt="QR Code" class="w-12 h-12">
                                    @else
                                        <span class="text-xs text-gray-500 italic">QR code non disponible</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-blue-600 underline break-all max-w-xs">
                                    @if($link->qrCode)
                                        <a href="{{ url($link->shortcut_link) . '.' }}" target="_blank">{{ url($link->shortcut_link) . '.' }}</a>
                                    @else
                                        <span class="text-xs text-gray-500 italic">Non disponible</span>
                                    @endif
                                </td>
                                </td>
                                {{-- Protégé --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"> 
                                    <div class="flex flex-col items-center justify-center space-y-1">

                                        {{-- Checkbox et Label --}}
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" disabled {{ $link->password_protected ? 'checked' : '' }} class="form-checkbox text-indigo-600 rounded shadow-sm">
                                            <span class="text-sm font-medium text-gray-700">Protégé</span>
                                        </div>

                                        {{-- Mot de passe --}}
                                        @if($link->password_protected)
                                            <div class="text-xs font-mono text-gray-500 mt-1">
                                                ********
                                            </div>
                                        @endif

                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $link->counter}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">   
                                    <div class="flex flex-col items-start space-y-2">                     
                                        <a href="{{ route('links.edit', $link) }}" class="inline-block w-24 mr-2 px-3 py-2 bg-yellow-500 text-white text-xs font-medium rounded-lg hover:bg-yellow-600 text-center" onclick="return confirm('Êtes-vous sûr pour modifier?')">MODIFIER</a>
                                        <form action="{{ route('links.destroy', $link->link_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                            <button type="submit" class="inline-block w-24 px-3 py-2 bg-red-600 text-white text-xs font-medium rounded-lg hover:bg-red-700 text-center" onclick="return confirm('Êtes-vous sûr pour suprimer ?')">SUPPRIMER</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>            
            </div>
        </div>
    </div>
</x-app-layout>
