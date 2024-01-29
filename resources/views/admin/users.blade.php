<!-- resources/views/livewire/user-list.blade.php -->

<div>
    <x-app-layout>
        @livewire('ban-user-modal', ['users' => $users])
    </x-app-layout>
</div>
