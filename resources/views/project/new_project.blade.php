<form action="{{ route('project.create.post')}}" method="POST">
    @csrf
    <input name="title" placeholder="Nom du projet..." type="text">
    <input name="description" type="text">
    <button>Envoyer</button>
</form>