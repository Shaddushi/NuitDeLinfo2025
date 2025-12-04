clear:
	php bin/console cache:clear

run:
	symfony server:start --no-tls

route:
	php bin/console debug:route

create-migration:
	php bin/console doctrine:migrations:diff

migrate:
	php bin/console doctrine:migrations:migrate

create-db:
	php bin/console doctrine:database:create

install:
	composer install
	touch .env.local
	echo DATABASE_URL="postgresql://postgres:root@localhost:5432/devfecations?serverVersion=16.11" > .env.local
	echo "TOKEN_EXP=31536000	# 1 an en secondes" >> .env.local
	echo TOKEN_PASS="p@ssw0rd" >> .env.local
	echo TOKEN_WEBSITE="localhost" >> .env.local

dotenv:
	php bin/console debug:dotenv
