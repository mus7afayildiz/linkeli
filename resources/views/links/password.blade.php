<x-app-layout>
    <x-slot name="header">
        <h2>Mot de passe requis</h2>
    </x-slot>

    <div>
        <div >
            <form method="POST" action="{{ route('links.verifyPassword', $link->shortcut_link) }}">
                @csrf
                <div class="mb-4">
                    <label for="password">Entrez le mot de passe</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit">Accéder au lien</button>
            </form>
        </div>
    </div>
</x-app-layout>
