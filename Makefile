LOCALHOST_PROJECT_DIR := $(shell pwd)
PROJECT_NAME := project
COMPOSE_FILE := ./docker-compose.yml

.DEFAULT_GOAL := help

help:## This is help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: help


echo-project-dir:## Show current working directory.
	@echo $(LOCALHOST_PROJECT_DIR)
	@echo $(PROJECT_NAME)

.PHONY: echo-project-dir

print:## print
	@printenv

.PHONY: print

up-dev: ## Up current containers for dev
	docker-compose -f $(COMPOSE_FILE) up -d

print-compose-file:## print compose file
	@echo $(COMPOSE_FILE)

.PHONY: up-dev print-compose-file

nginx-exec:## enter nginx exec
	docker exec -it $(PROJECT_NAME)-nginx sh

.PHONY: nginx-exec


php-exec: ## Run any php command in our container
	docker exec -it $(PROJECT_NAME)-php sh

.PHONY: php-exec

stop-dev:## stop docker containers
	docker-compose stop

.PHONY: stop-dev

php-exec-cmd: CMD?=-r 'phpinfo();'
php-exec-cmd: ## Run any php command in our container
	docker exec $(PROJECT_NAME)-php php $(CMD)

.PHONY: php-exec

ps:
	docker-compose ps

.PHONY: ps

i:## print docker ps
	composer install

.PHONY: i
