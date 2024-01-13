<form action="{{ route('project.update') }}">
    @csrf
    <input class="text-xl font-semibold" name="title" placeholder="Nom du projet..." type="text" value="{{ $project->title }}">
    <input class="text-xl font-semibold" name="description" type="text" value="{{ $project->description }}">
    <input type="file" name="image" accept="image/*">
    <button>Modifier</button>
</form>