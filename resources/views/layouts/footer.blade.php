<footer class="block bg-gray-950 text-white p-4 mt-auto flex-shrink-0">
    <div class="container mx-auto flex flex-col lg:flex-row justify-between items-center">
        <div class="flex flex-col items-center mb-4 lg:mb-0">
            <x-application-mark class="block h-9 w-auto" />
            <p class="text-xl font-semibold"> Propodile</p>
        </div>

        <div class="flex space-x-4">
            <a href="{{ route('home') }}" class="hover:text-gray-300">Accueil</a>
            <a href="{{ route('profile.show') }}" class="hover:text-gray-300">Mon profil</a>
            <a href="https://www.epsi.fr/" class="hover:text-gray-300">Epsi kesako ?</a>
        </div>
    </div>

    <div class="text-center mt-4">
        <p>&copy; {{ now()->year }} Propodile. Tous droits réservés.</p>
    </div>
</footer>
