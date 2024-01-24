<x-guest-layout>
    <x-project-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-6" />

        <div class="text-2xl font-semibold text-center mb-8">{{ __('Créer un nouveau projet') }}</div>

        <form action="{{ route('project.create.post') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mt-6">
                <x-label for="title" value="{{ __('Nom du projet') }}" class="text-lg" />
                <x-input id="title" class="block w-full mt-2" type="text" name="title" required autofocus />
            </div>

            <div class="mt-6">
                <x-label for="description" value="{{ __('Description') }}" class="text-lg" />
                <x-textarea id="description" class="block w-full mt-2 h-40" type="text" name="description" required />
            </div>

            <div class="mt-6">
                <x-label for="status" value="{{ __('Status') }}" class="text-lg" />
                <x-select name="status" class="block w-full">
                    @foreach (\App\Models\Status::all() as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mt-6">
                <x-label for="image" value="{{ __('Image') }}" class="text-lg" />
                <x-input type="file" name="image" id="image" accept="image/*" class="mt-2 max-w-full" />
            </div>

            <div class="mt-8 text-center">
                <x-button>
                    {{ __('Créer un projet') }}
                </x-button>
            </div>
        </form>
    </x-project-card>
</x-guest-layout>
