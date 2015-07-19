# MongoUI
Interface utilisateur pour les bases de données Mongo (mongomyadmin)

## Installation sur *NIX
http://php.net/manual/fr/mongo.installation.php#mongo.installation.nix

## Installation sur Windows
http://php.net/manual/fr/mongo.installation.php#mongo.installation.windows

## Installation sur Mac
http://php.net/manual/fr/mongo.installation.php#mongo.installation.osx

## Guide d'utilisation

### Prérequis

1. Avoir une base de données Mongo
2. Un utilisateur admin ayant les droits userAdminAnyDatabase ET dbAdminAnyDatabase sur la base de données "admin"

### Url d'accès

http://"host":"port"/mongomyadmin

### Gestion de collections et de documents

1. Ce connecter avec un utilisateur ayant les permissions readWrite ou readWriteAnyDatabase.
2. Entrez le nom de la collection (champ Database) auquel l'utilisateur a ces permissions.

### Gestion de base de données et d'utilisateurs
	
1. Ce connecter avec l'utilisateur ayant les permissions userAdminAnyDatabase ET dbAdminAnyDatabase.
2. Dans le champs Database, entrez "admin" (la base administrateur de mongodb).