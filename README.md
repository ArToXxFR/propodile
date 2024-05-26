# Propodile

Propodile est un projet dédié à l'épreuve du BTS SIO (Services Informatiques aux Organisations), offrant une plateforme permettant de mettre en relation les étudiants au sein de l'école pour collaborer sur des projets communs. Chaque membre de l'école peut s'inscrire, proposer un projet ou demander à rejoindre un projet existant. L'administration de l'école dispose également d'une interface lui permettant de gérer les projets, avec la possibilité de les modifier ou de les supprimer en cas d'abus.

## Contribution
----------------------------

- Sterenn Languille : https://github.com/Jotaro15
- Lucas Chevalier : https://github.com/Lucas-Chevalier
- Emilien CUNY : https://github.com/ArToXxFR

## Technologies Utilisées
----------------------------


- **Laravel**: Un framework PHP élégant pour le développement web.
- **Node.js**: Un environnement d'exécution JavaScript côté serveur.
- **Composer**: Un gestionnaire de dépendances pour PHP.
- **Git**: Un système de contrôle de version distribué.

## Documentation
----------------------------

La documentation complète du projet est disponible [ici](https://github.com/ArToXxFR/propodile/wiki)

## Tester le projet

Il est possible de tester directement le projet à l'adresse suivante : 

- [propodile.cuny.engineer](https://propodile.cuny.engineer)

Il est également possible de tester l'application avec un compte administrateur avec les identifiants suivants :

Identifiant : admin

Mot de passe : 7MrOcjlCkzAM62z

:information_source: Les identifiants sont uniquement disponible car le projet est encore en face de test et permet aux
jury du BTS SIO de pouvoir tester l'application.

## Installation
----------------------------

Suivez ces instructions pour configurer et exécuter Propodile sur votre machine locale.

### Prérequis

- [Git](https://git-scm.com/)
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)

### Installation

1. Clonez le dépôt Propodile :

    ```bash
    git clone https://github.com/ArToXxFR/propodile.git
    ```

2. Accédez au répertoire du projet :

    ```bash
    cd propodile/
    ```

3. Installez les dépendances PHP avec Composer :

    ```bash
    composer install
    ```

4. Installez les dépendances Node.js :

    ```bash
    npm install
    ```

5. Modifiez le fichier `.env` :

   Mettez à jour les configurations nécessaires dans le fichier `.env`, telles que les détails de connexion à la base de données.

6. Générez la clé d'application :

    ```bash
    php artisan key:generate
    ```

7. Créez des liens symboliques pour le stockage :

    ```bash
    php artisan storage:link
    ```

8. Exécutez les migrations de la base de données :

    ```bash
    php artisan migrate --seed
    ```

### Exécution de l'application

Pour démarrer Propodile, utilisez les commandes suivantes :

- Lancez le serveur de développement PHP :

    ```bash
    php artisan serve
    ```

- Compilez et surveillez les modifications des assets :

    ```bash
    npm run dev
    ```

Vous pouvez maintenant accéder à Propodile en vous rendant sur [http://localhost:8000](http://localhost:8000) dans votre navigateur web.

