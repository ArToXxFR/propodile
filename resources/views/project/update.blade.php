<form action="{{ route('project.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input class="text-xl font-semibold" name="title" placeholder="Nom du projet..." type="text" value="{{ $project->title }}">
    <input class="text-xl font-semibold" name="description" type="text" value="{{ $project->description }}">
    <select name="status">
        @foreach ($statuses as $status)
            <option value="{{ $status->id }}" {{ $project->status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
        @endforeach
    </select>
    <input type="file" name="image" accept="image/*">
    <input type="hidden" name="id" value="{{ $project->id }}">
    <button>Modifier</button>
</form>
