@foreach ($projects as $project)
    {{ $project->title }}
    <a href="{{ route('project.show', ['id' => $project->id])}}">Voir le projet</a>
@endforeach
