composer-install:
	@docker compose exec dbm composer install --verbose

composer-update:
	@docker compose exec dbm composer update --verbose

test-group:
	@docker compose exec dbm php /app/vendor/bin/phpunit --no-coverage --color=always --group ${GROUP}

test-coverage:
	@docker compose exec -e XDEBUG_MODE=coverage dbm php /app/vendor/bin/phpunit --color=always

up:
	@docker compose up

down:
	@docker compose down
