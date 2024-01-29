<div id="{{ "deleteModal-" . $user->id }}"  class="fixed inset-0 z-10 flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
    <div class="relative bg-white rounded-lg p-8 mx-auto my-32 md:max-w-2xl w-full">
        <h2 class="text-4xl font-semibold mb-8">Supprimer l'utilisateur ?</h2>
        <h3 class="mb-6 text-red-600 font-bold">⚠️ Attention ⚠️</h3>
        <p class="mb-6 text-red-600 font-bold"> Cette action est irréversible et supprimera définitivement l'utilisateur ainsi que toutes ses données. Êtes-vous sûr de vouloir procéder ?</p>


        <!-- Formulaire pour la suppression -->
        <form id="deleteForm" action="{{ route('admin.user.delete', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-between">
                <button type="button" class="px-6 py-2 border bg-white border-gray-700 text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-700 transition duration-300 ease-in-out" onclick="closeDeleteModal({{ $user->id }})">Annuler</button>
                <button type="submit" class="px-4 py-2 border bg-white border-red-500 text-red-500 rounded-md hover:bg-red-300 hover:text-red-500 transition duration-300 ease-in-out">Supprimer</button>
            </div>
        </form>
    </div>
</div>


