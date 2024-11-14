IMAGE_NAME=dbm
IMAGE_TAG=dev
RUN_COMMAND=docker run --rm -v ${PWD}:/app -w /app $(IMAGE_NAME):$(IMAGE_TAG)
COMPOSER_COMMAND=$(RUN_COMMAND) composer

build:
	@docker build . -t $(IMAGE_NAME):$(IMAGE_TAG)

composer-install:
	@$(COMPOSER_COMMAND) install --verbose

composer-update:
	@$(COMPOSER_COMMAND) update --verbose

test-group:
	@docker compose exec dbm php /app/vendor/bin/phpunit --no-coverage --color=always --group ${GROUP}

test-coverage:
	@docker compose exec -e XDEBUG_MODE=coverage dbm php /app/vendor/bin/phpunit --color=always

setup: build composer-install

up:
	@docker compose up

down:
	@docker compose down