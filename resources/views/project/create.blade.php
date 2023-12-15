<form action="{{ route('project.create.post')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input name="title" placeholder="Nom du projet..." type="text">
    <input name="description" type="text">
    <input type="file" name="image">
    <button>Envoyer</button>
</form>