<div id="confirmJoinProjectModal" class="fixed inset-0 z-10 flex items-center justify-center hidden">
    <div class="fixed inset-0 bg-gray-900 opacity-50"></div>
    <div class="relative bg-white rounded-lg p-8 mx-auto my-32 md:max-w-2xl w-full">
        <h2 class="text-3xl font-semibold mb-6">Confirmer la demande</h2>
        <p class="text-gray-700 mb-6">Êtes-vous sûr de vouloir demander à rejoindre le projet ?</p>

        <div class="flex justify-between">
            <button type="button" onclick="closeJoinProjectModal()" class="px-6 py-2 border bg-white border-gray-700 text-gray-700 rounded-md hover:bg-gray-200 hover:text-gray-700 transition duration-300 ease-in-out">Annuler</button>
            <form id="joinProjectForm" action="{{ route("team.join") }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $project->id }}" name="id">
                <input type="hidden" value="{{ $project->team_id }}" name="team_id">
                <button type="submit" class="px-4 py-2 border bg-white border-yellow-500 text-yellow-500 rounded-md hover:bg-yellow-300 hover:text-yellow-500 transition duration-300 ease-in-out">Confirmer</button>
            </form>
        </div>
    </div>
</div>
