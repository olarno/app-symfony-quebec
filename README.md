# Symfony Québec — site vitrine

Site de **Symfony Québec**, organisation qui organise, facilite et promeut la présence de Symfony
au Québec et au Canada : meetups, conférences, cercle de professionnels, etc.

> ⚠️ Ébauche : les événements, commanditaires et membres de l'équipe sont des données d'exemple
> (`src/DataFixtures/AppFixtures.php`) à remplacer par le vrai contenu.

## Stack

- PHP 8.5, Symfony 8.1
- Twig + AssetMapper (aucun build Node), Stimulus / Turbo
- Doctrine ORM + SQLite (`var/data_<env>.db`)
- Symfony Form, Validator, Mailer (formulaire de contact)

## Pages

| URL | Contenu |
| --- | --- |
| `/` | Présentation, piliers (meetups, conférences, cercle pro, carte), événements à venir et passés, commanditaires |
| `/evenements` et `/evenements/{slug}` | Liste complète des événements à venir / passés et fiche détaillée |
| `/commanditaires` | Commanditaires par palier + « Devenir commanditaire » (paliers, démarche) |
| `/equipe` | Présentation de l'équipe (conférenciers identifiés) |
| `/applications` | Lien vers la carte interactive des développeurs et entreprises Symfony |
| `/contact` | Formulaire : conférence, expertise, événement, commandite, autre. Le sujet peut être pré-sélectionné : `/contact?sujet=conference` |

## Démarrer

```bash
composer install
php bin/console doctrine:migrations:migrate -n
php bin/console doctrine:fixtures:load -n   # données d'exemple
symfony serve                                # ou : php -S 127.0.0.1:8000 -t public
```

## Configuration (`.env` / `.env.local`)

| Variable | Rôle |
| --- | --- |
| `APP_MAP_URL` | URL de l'application « carte interactive » |
| `APP_CONTACT_EMAIL` | Adresse qui reçoit les demandes du formulaire de contact |
| `MAILER_DSN` | Transport courriel (`null://null` par défaut ; `compose.yaml` fournit Mailpit en dev) |
| `DATABASE_URL` | SQLite par défaut |

## Tests

```bash
php bin/phpunit
```

La base de test est recréée et chargée avec les fixtures à chaque exécution (`tests/bootstrap.php`).

## Pistes pour la suite

- Back-office (ex. EasyAdmin) pour gérer événements, commanditaires et équipe sans fixtures
- Version anglaise (le site est prêt pour le composant Translation)
- Logos des commanditaires et photos de l'équipe (`public/images/...`)
- Inscription aux événements / infolettre, pages légales (Loi 25)
