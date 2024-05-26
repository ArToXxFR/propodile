<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Invitation dans une équipe - Propodile</title>
    <style>
        /* Style général */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        /* Conteneur principal */
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Titre */
        .title {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Paragraphe */
        .paragraph {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Boutons */
        .button {
            display: inline-block;
            background-color: darkslategray;
            color: #fff;
            padding: 25px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        /* Conteneur de boutons */
        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
<div class="container">
    <h1 class="title">Invitation dans une équipe - Propodile</h1>

    <p class="paragraph">Vous avez été invité à rejoindre l'équipe : <strong>{{ $invitation->team->name }}</strong></p>

    <div class="button-container">
        <a href="{{ $acceptUrl }}" class="button">Accepter l'invitation</a>
    </div>

    <p class="paragraph">Si vous n'avez pas de compte, vous pouvez en créer un en cliquant sur le bouton ci-dessous :</p>

    <div class="button-container">
        <a href="{{ route('register') }}" class="button">Créer un compte</a>
    </div>

    <p class="paragraph">Si vous n'attendiez pas de recevoir une invitation pour rejoindre cette équipe, vous pouvez ignorer cet email.</p>
</div>
</body>
</html>
