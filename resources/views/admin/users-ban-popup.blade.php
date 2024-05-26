<div id="{{ "banModal-" . $user->id }}" class="fixed inset-0 z-10 flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
    <div class="relative bg-white rounded-lg p-8 mx-auto my-32 md:max-w-2xl w-full">
        <h2 class="text-4xl font-semibold mb-8">Bannir {{ $user->firstname }} {{ $user->lastname }} ?</h2>

        <form action="{{ route('admin.user.ban', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label for="banEndDate" class="block text-lg font-medium text-gray-700">Date de fin du bannissement (Laissez vide pour un bannissement permanent)</label>
                <input type="date" id="banEndDate" name="date" class="mt-2 p-3 block w-full border rounded-md" min="{{ now()->toDateString() }}">
                @error('banEndDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-between">
                <button type="button" class="px-4 py-2 border bg-white border-gray-700 text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-700 transition duration-300 ease-in-out" onclick="closeBanModal({{ $user->id }})">Annuler</button>
                <button type="submit" class="px-4 py-2 border bg-white border-red-500 text-red-500 rounded-md hover:bg-red-300 hover:text-red-500 transition duration-300 ease-in-out">Bannir</button>
            </div>
        </form>
    </div>
</div>
