<div align="center">

# 💉 LeDoc API 💉

</div>

## Installation

Lancer les conteneurs Docker (console Debian):

```bash
cd devPhpLP
make up
```

Mettre à jour le projet (n'importe quelle console):

```bash
cd projets/ledocsf
git pull
```

Installer les dépendances (console Debian) :

```bash
cd devPhpLP
make bash
cd ledocsf
composer install
exit
```

## Configuration du projet

Base de données (console Debian):

- regarder la migration la plus récente dans /migrations/VersionYYYYMMDDhhmmss.php
- `cd devPhpLP`
- `make bash`
- `cd ledocsf`
- `php bin/console doctrine:migrations:latest`
- votre version est-elle la dernière ?
- si vous n'avez pas la dernière {
    - `php bin/console doctrine:migrations:migrate`
    - pour purger la base de données et générer de nouvelles données :
    - `php bin/console doctrine:fixtures:load`
    - `yes`
    - pour ajouter plus de données dans la base :
    - `php bin/console doctrine:fixtures:load --append`
- } else {
    - peut-être que la génération des fausses données a été modifiée :
    - `php bin/console doctrine:fixtures:load`
    - `yes`
- }
- votre base de données est prête, enjoy !
- `exit`

## Notes

Pour la création d'une tournée, le schéma ne permettait pas de préciser directement les individualVisits faisant partie de la tournée, car il fallait rentrer le startTime de la tourVisit, mais aussi de toutes les individualVisit liées.

Pour créer une tourVisit avec ses individualVisit, il faut donc créer une tourVisit en POST sans individualVisit puis utiliser un PUT pour ajouter les individualVisit.

Nous n'avons pas de table pour les statistiques car ces données sont censées être calculer avec les données de la base et non pas être des données fixes dans la base.
