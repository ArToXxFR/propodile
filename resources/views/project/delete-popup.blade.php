<div id="deleteProjectModal" class="fixed inset-0 z-10 flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
    <div class="relative bg-white rounded-lg p-8 mx-auto my-32 md:max-w-2xl w-full">
        <h2 class="text-3xl font-semibold mb-6">Supprimer le projet</h2>
        <p class="text-gray-700 mb-6">Cette action est irréversible. Êtes-vous sûr de vouloir supprimer le projet ?</p>

        <div class="flex justify-between">
            <button type="button" onclick="closeDeleteProjectModal()" class="px-6 py-2 border bg-white border-gray-700 text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-700 transition duration-300 ease-in-out">Annuler</button>
            <form method="POST" action="{{ route("project.delete", ['id' => $project->id]) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 border bg-white border-red-500 text-red-500 rounded-md hover:bg-red-300 hover:text-red-500 transition duration-300 ease-in-out">Supprimer</button>
            </form>
        </div>
    </div>
</div>
