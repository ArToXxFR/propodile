@section('title', 'Créer une équipe')
<x-app-layout>
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

            <div class="mt-6 relative">
                <x-label for="description" value="{{ __('Description') }}" class="text-lg" />
                <x-textarea id="description" class="block w-full mt-2 h-40" type="text" name="description" required>{{ old('description') }}</x-textarea>
                <div class="absolute bottom-2 right-2 text-gray-400">
                    <span id="charCount">{{ mb_strlen(old('description')) }}</span>/1080
                </div>
            </div>

            <div class="mt-6">
                <x-label for="status_id" value="{{ __('Status') }}" class="text-lg" />
                <x-select name="status_id" class="block w-full">
                    @foreach (\App\Models\Status::all() as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="mt-6">
                <x-label for="tags" value="{{ __('Technologies') }}" class="text-lg" />
                <x-input id="tags" class="block w-full mt-2" type="text" name="tags" placeholder="Exemple : Docker, Laravel, ect..."/>
                <p class="text-gray-900">Conseil : Séparer les technologies par des virgules.</p>
                <p class="text-red-500" id="tagError"></p>
            </div>

            <div class="mt-6">
                <x-label for="image" value="{{ __('Image') }}" class="text-lg" />
                <x-input type="file" name="image" id="image" accept="image/*" class="mt-2 max-w-full" />
                <p class="mt-2 text-gray-500 text-sm">Conseil : Image de 500x500 pixels en format PNG.</p>
            </div>

            <div class="mt-8 text-center">
                <x-button>
                    {{ __('Créer un projet') }}
                </x-button>
            </div>
        </form>
    </x-project-card>
</x-app-layout>

<script>
    document.getElementById('description').addEventListener('input', function () {
        let charCount = this.value.length;
        document.getElementById('charCount').innerText = charCount;
    });
</script>

