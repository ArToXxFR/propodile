<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Demande de rejoindre votre projet</title>
    <style>
        /* Style général */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Conteneur principal */
        .container {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        /* Titre */
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Paragraphe */
        .paragraph {
            line-height: 1.5;
            margin-bottom: 20px;
        }

        /* Boutons */
        .button {
            background-color: darkslategray;
            color: #fff;
            padding: 30px 20px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="title">Demande de rejoindre votre projet</h1>

    <p class="paragraph">{{ $user }} a demandé à rejoindre votre projet !</p>

    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
        <p class="paragraph">Si vous n'avez pas de compte, vous pouvez en créer un en cliquant sur le bouton ci-dessous. Après avoir créé un compte, vous pourrez cliquer sur le bouton d'acceptation de l'invitation dans cet email pour accepter la demande :</p>

        <a href="{{ route('register') }}" class="button">Créer un compte</a>
    @endif

    <p class="paragraph">Si vous avez déjà un compte, vous pouvez accepter cette demande en cliquant sur le bouton ci-dessous :</p>

    <a href="{{ $acceptUrl }}" class="button">Accepter la demande</a>

    <p class="paragraph">Vous pouvez également consulter le profil de {{ $user }} en cliquant sur le lien ci-dessous :</p>

    <a href="{{ $profileUrl }}" class="button">Voir le profil de {{ $user }}</a>

    <p class="paragraph">Si vous n'attendiez pas de recevoir une demande pour rejoindre ce projet, vous pouvez ignorer cet email.</p>
</div>
</body>
</html>

