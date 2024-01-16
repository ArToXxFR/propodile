<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tous les projets</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite('resources/css/app.css')
    </head>
    <body>
        <div class="flex flex-wrap justify-center w-screen">
            <form action="{{ route('project.create.post')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input class="text-xl font-semibold" name="title" placeholder="Nom du projet..." type="text">
                <input class="text-xl font-semibold" name="description" type="text">
                <select name="status">
                    @foreach (\App\Models\Status::all() as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
                <input type="file" name="image" accept="image/*">
                <button>Envoyer</button>
            </form>
        </div>
