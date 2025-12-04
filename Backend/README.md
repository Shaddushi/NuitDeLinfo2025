# API Symfony

## Prérequis
- PHP 8.4 ou supérieur et les extentions
[Ctype](https://www.php.net/book.ctype),
[iconv](https://www.php.net/book.inconv),
[PCRE](https://www.php.net/book.pcre),
[Session](https://www.php.net/book.session),
[SimpleXML](https://www.php.net/book.simplexml) &
[Tokenizer](https://www.php.net/book.tokenizer)

- [Composer](https://getcomposer.org/download)
- [Symfony CLI](https://symfony.com/download)
- [PostGreSQL (version 16 ou plus)](https://www.postgresql.org/download)

- Bonus : utilisation de Linux (natif ou WSL) pour utiliser les Makefile,
mais toutes les commandes sont compatibles Windows/MacOS/Linux

## Installation
- Télécharger le répo `git clone https://github.com/HugoFOLLET/TemplateSymfony.git`
- Installer les dépendances `make install`
- Modifier les informations d'environnement :
- - Dans `DATABASE_URL="postgresql://postgres:root@localhost:5432/devfecations?serverVersion=16.11"`
modifier `postgres` par l'utilisateur BDD souhaité, `root` par le mot de passe de l'utilisateur,
`16.11` par la version de la base de données PostGreSQL. Attention : l'utilisateur doit avoir le droit
de créer une base de données pour la commande suivante.
- Initialiser la BDD `make create-db` (ou créer la base de données à la main, avec le nom correct)
- Apporter les migrations `make migrate`
- Lancer le serveur `make run`
