
# Dev4Earth — CMS de Data Storytelling

## Description
**Dev4Earth** est une application web de **data storytelling** permettant de créer, gérer et publier des articles enrichis par des visualisations de données interactives.

L’application combine :

- narration éditoriale,

- graphiques dynamiques,

- dashboards,

- personnalisation graphique (thèmes),

- gestion de jeux de données (CSV / API).

Elle s’adresse à des créateurs de contenu, analystes, designers et administrateurs souhaitant raconter des histoires à partir de données.
***
## Fonctionnalités principales

1. **Gestion des utilisateurs**
2. **Gestion des articles**
3. **Visualisations de données**
4. **Gestion des données**
5. **Thèmes & personnalisation**

***
## Architecture Technique

1. **Stack**

Service|	Technologies
--------|-------------------
Serveur web	 |Nginx
backend	|Symfony (PHP 8.3)
Base de données	|MySQL 8
frontend|	Vite + JavaScript
Admin DB|	phpMyAdmin
Conteneurisation|	Docker & Docker Compose

2. **Services Docker**

Service|	Description
--------|-------------------
db	 |Base MySQL
backend	|API Symfony
nginx	|Reverse proxy
frontend|	Interface utilisateur
phpmyadmin|	Administration DB

***
## Installation & Lancement

1. **Prérequis**

***Docker***

Vous pouvez le telecharger depuis ce site: 
<https://www.docker.com/>

**Lancement du projet**

Ouvrez le projet dans VS Code.

Dans un terminal, placez-vous à la racine du projet, puis lancez les services Docker :

```
docker compose up -d
```

Accédez au conteneur backend :

```
docker compose exec backend bash
```
Exécutez les migrations de la base de données :
```
php bin/console doctrine:migrations:migrate
```
Chargez les fixtures :
```
php bin/console doctrine:fixtures:load
```
Générez les clés JWT (à faire une seule fois) :
```
php bin/console lexik:jwt:generate-keypair
```
Quittez le conteneur backend :
```
exit
```


## Contact

Pour plus d'information contacter nous !
<ngaleufresnel@gmail.com> & <megane.farelle@gmail.com>



