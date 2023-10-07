up:
	docker-compose up -d

stop:
	docker-compose stop

build:
	docker-compose build

in:
	docker exec -ti gentree_app_1 /bin/sh

init: stop build up

restart: stop up

run:
	docker exec -it gentree_app_1 sh -c "php -f src/index.php"

test:
	docker exec -it gentree_app_1 sh -c "./vendor/bin/phpunit tests"

