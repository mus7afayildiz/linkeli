<x-guest-layout>
    <x-slot name="header">
        <h2>Mot de passe requis</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-6">    
                    <form method="POST" action="{{ route('links.verifyPassword', ['shortcut' => $link->shortcut_link]) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="password" class="block font-medium text-sm text-gray-700">Entrez le mot de passe</label>
                            <input type="password" name="password" id="password" required class="w-full mt-1 px-3 py-2 border border-gray-300 rounded-lg shadow-sm bg-gray-100 text-gray-900 ">
                            @if ($errors->has('password'))
                                <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700 transition duration-200">Accéder au lien</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
