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

test-coverage:
	@$(RUN_COMMAND) php -dxdebug.mode=coverage ./vendor/bin/phpunit --color=always

test-group:
	@$(RUN_COMMAND) php ./vendor/bin/phpunit --no-coverage --color=always --group ${GROUP}

setup: build composer-install