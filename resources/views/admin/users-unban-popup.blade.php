<div id="{{ "unBanModal-" . $user->id }}" class="fixed inset-0 z-10 flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
    <div class="relative bg-white rounded-lg p-8 mx-auto my-32 md:max-w-2xl w-full">
        <h2 class="text-4xl font-semibold mb-8">Débannir {{ $user->firstname }} {{ $user->lastname }} ?</h2>

        <form action="{{ route('admin.user.unban', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="flex justify-between">
                <button type="button" class="px-6 py-2 border bg-white border-gray-700 text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-700 transition duration-300 ease-in-out" onclick="closeUnBanModal({{ $user->id }})">Annuler</button>
                <button type="submit" class="px-4 py-2 border bg-white border-green-700 text-green-700 rounded-md hover:bg-green-300 hover:text-green-700 transition duration-300 ease-in-out">Débannir</button>
            </div>
        </form>
    </div>
</div>
