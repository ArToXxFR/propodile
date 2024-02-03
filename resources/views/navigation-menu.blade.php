<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                @guest
                    <div class="flex tems-center ml-auto space-x-2">
                        <x-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')" class="sm:hidden">
                            <button class="bg-white hover:bg-blue-300 text-blue-500 border-blue-500 border font-bold py-2 px-3 rounded text-sm">
                                {{ __('Se connecter') }}
                            </button>
                        </x-nav-link>

                        <x-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')" class="sm:hidden">
                            <button class="bg-white hover:bg-blue-300 text-green-500 border-green-500 border font-bold py-2 px-3 rounded text-sm">
                                {{ __('Créer un compte') }}
                            </button>
                        </x-nav-link>
                    </div>
                @endguest

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-4 sm:flex">
                    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Page d\'accueil') }}
                    </x-nav-link>
                </div>

                @auth
                    <div class="hidden space-x-2 sm:-my-px sm:ms-4 sm:flex">
                        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                            {{ __('Tableau de bord') }}
                        </x-nav-link>
                    </div>
                @endauth
            </div>



            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Teams Dropdown -->
                @auth
                    <div class="ms-3 relative">
                        @if(Auth::user()->isAdmin())
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        Administration
                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </button>
                                </span>
                                </x-slot>
                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Administration') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                        {{ __('Tableau de bord') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link href="{{ route('admin.projects') }}">
                                        {{ __('Liste des projets') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link href="{{ route('admin.users') }}">
                                        {{ __('Liste des utilisateurs') }}
                                    </x-dropdown-link>
                                </div>
                            </x-slot>

                            </x-dropdown>
                        @endif
                    </div>

                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    Mes projets
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </button>
                            </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Gérer mes projets') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('dashboard') }}">
                                        {{ __('Mes projets') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('project.create.form') }}">
                                            {{ __('Créer un nouveau projet') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Liste de mes projets') }}
                                    </div>
                                    @if(Auth::user()->projects->count() > 0)
                                        @foreach(Auth::user()->projects as $project)
                                            <x-dropdown-link href="{{ route('project.show', ['id' => $project->id]) }}">
                                                {{ __($project->title) }}
                                            </x-dropdown-link>
                                        @endforeach
                                    @else
                                        <div class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700">
                                            {{ __('Vous n\'avez pas encore de projets') }}
                                        </div>
                                    @endif
                                </div>
                            </x-slot>

                        </x-dropdown>
                    </div>

                    <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    <x-dropdown align="right" width="48">

                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->username }}

                                        <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Gérer mon compte') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Mon profil') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         @click.prevent="$root.submit();">
                                    {{ __('Se déconnecter') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>

                    </x-dropdown>
                </div>
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('Page d\'accueil') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->username }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->username }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-dropdown-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Mon profil') }}
                </x-dropdown-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-dropdown-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Se déconnecter') }}
                    </x-dropdown-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures() && Auth::user()->ownedTeams->count() > 0)
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Gérer mes projets') }}
                    </div>

                    <x-dropdown-link href="{{ route('dashboard') }}">
                        {{ __('Mes projets') }}
                    </x-dropdown-link>

                    <x-dropdown-link href="{{ route('project.create.form') }}" :active="request()->routeIs('project.create.form')">
                        {{ __('Créer un nouveau projet') }}
                    </x-dropdown-link>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Liste de mes projets') }}
                    </div>

                    @if(Auth::user()->projects->count() > 0)
                        @foreach(Auth::user()->projects as $project)
                            <x-dropdown-link href="{{ route('project.show', ['id' => $project->id]) }}">
                                {{ __($project->title) }}
                            </x-dropdown-link>
                        @endforeach
                    @else
                        <div class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700">
                            {{ __('Vous n\'avez pas encore de projets') }}
                        </div>
                    @endif

                    @if(Auth::user()->isAdmin())
                        <div class="w-60">
                            <!-- Team Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Administration') }}
                            </div>

                            <!-- Team Settings -->
                            <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                {{ __('Tableau de bord') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.projects') }}">
                                {{ __('Liste des projets') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('admin.users') }}">
                                {{ __('Liste des utilisateurs') }}
                            </x-dropdown-link>
                        </div>
                    @endif

                @endif
                @endauth
                @guest
                    <x-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:text-gray-700 focus:bg-gray-100 transition duration-150 ease-in-out">
                        {{ __('Se connecter') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:text-gray-700 focus:bg-gray-100 transition duration-150 ease-in-out">
                        {{ __('Créer un compte') }}
                    </x-responsive-nav-link>
                @endguest
            </div>
        </div>
    </div>
</nav>
