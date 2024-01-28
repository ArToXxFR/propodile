<!-- resources/views/livewire/ban-user-modal.blade.php -->

<div class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 max-w-md mx-auto rounded-md shadow-md">
        <h2 class="text-xl font-semibold mb-4">Bannir l'utilisateur</h2>
        <label for="banEndDate" class="block text-sm font-medium text-gray-700">Date de fin du bannissement</label>
        <input wire:model.defer="banEndDate" type="date" id="banEndDate" name="banEndDate" class="mt-1 p-2 border rounded-md">
        <button wire:click="banUser" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue active:bg-blue-700">Valider</button>
    </div>
</div>
