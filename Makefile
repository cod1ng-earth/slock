
MAKE = make --no-print-directory
DOCKER = docker
DOCKER_COMPOSE = docker-compose
CLI = $(DOCKER_COMPOSE) exec -T php
CONSOLE = $(CLI) ./bin/console
COMPOSER_PARAMS = --optimize-autoloader --ignore-platform-reqs

UNAME := $(shell uname)

# Add the following 'help' target to your Makefile
# And add help text after each target name starting with '\#\#'
# A category can be added with @category
HELP_FUN = \
	%help; \
	while(<>) { push @{$$help{$$2 // 'options'}}, [$$1, $$3] if /^([a-zA-Z\-]+)\s*:.*\#\#(?:@([a-zA-Z\-]+))?\s(.*)$$/ }; \
	print "usage: make [target]\n\n"; \
	for (sort keys %help) { \
	print "${WHITE}$$_:${RESET}\n"; \
	for (@{$$help{$$_}}) { \
	$$sep = " " x (32 - length $$_->[0]); \
	print "  ${YELLOW}$$_->[0]${RESET}$$sep${GREEN}$$_->[1]${RESET}\n"; \
	}; \
	print "\n"; }

# Process parameters/options
CONTAINERS := php api cache-proxy db mercure client admin h2-proxy

ifeq (cli,$(firstword $(MAKECMDGOALS)))
    ifndef container
        CONTAINER := php
    else
        ifeq ($(filter $(container),$(CONTAINERS)),)
            $(error Invalid container. $(CONTAINER) does not exist in $(CONTAINERS))
        endif
        CONTAINER := $(container)
    endif
endif

ifeq (composer-update,$(firstword $(MAKECMDGOALS)))
    PACKAGES =
    ifdef packages
        PACKAGES := $(packages)
    endif
endif

ifeq (logs,$(firstword $(MAKECMDGOALS)))
    LOGS_TAIL := 0
    ifdef tail
        LOGS_TAIL := $(tail)
    endif
endif

help: ##@other Show this help.
	@perl -e '$(HELP_FUN)' $(MAKEFILE_LIST)
.PHONY: help

start: ##@development start containers
	$(DOCKER_COMPOSE) up -d
.PHONY: start

logs: ##@development show server logs (default: 0, use parameter 'tail=<#|all>, e.g. call 'make logs tail=all' for all logs, add `make logs tail=10' or any number for specific amount of lines)
	$(DOCKER_COMPOSE) logs -f --tail=$(LOGS_TAIL)
.PHONY: logs

cli: ##@development get shell in a container (defaults: cli (container), /bin/sh (shell), add 'container={container}' to use different container, e.g. 'make cli container=postgres', add 'shell={shell}' to use different shell, e.g. 'make cli shell=/bin/bash')
	$(DOCKER_COMPOSE) exec $(CONTAINER) sh
.PHONY: cli

stop: ##@development stop containers
	$(DOCKER_COMPOSE) stop -t 1
.PHONY: stop

restart: stop start ##@development restart containers
.PHONY: restart

clean: ##@setup stop and remove containers
	$(MAKE) stop
	$(DOCKER_COMPOSE) down --remove-orphans
.PHONY: clean

rebuild: ##@development removes images
	$(DOCKER_COMPOSE) down --rmi all
	$(MAKE) setup
.PHONY: rebuild

update-containers: build-images start ##@development updates containers
.PHONY: update-containers

build-images: ##@setup build docker images
	$(DOCKER_COMPOSE) build
.PHONY: build-images

update-setup: build-images start ##@setup update docker setup
.PHONY: update-setup

setup: build-images start codebase-update ##@setup Create dev enviroment
.PHONY: setup

codebase-update: composer-install ##@development updates code (composer install, codecept build)
.PHONY: codebase-update

composer-install: ##@development run 'composer install' in container
	$(CLI) composer install --ansi $(COMPOSER_PARAMS)
.PHONY: composer-install

composer-update: ##@development run 'composer update', to update specific package add 'packages={packages}, e.g. 'make composer-update packages="phpunit/phpunit spryker/cache"'
	$(CLI) php -dmemory_limit=-1 /usr/local/bin/composer update  --ansi $(COMPOSER_PARAMS) $(PACKAGES)
.PHONY: composer-update

docker-stats: ##@other show information about running Docker containers
	$(DOCKER) stats --format "table {{.Container}}\t{{.Name}}\t{{.CPUPerc}}\t{{.MemPerc}}\t{{.BlockIO}}"
.PHONY: docker-stats

fixtures: vendor ##@development run 'bin/console hautelook:fixtures:load' in container
	$(CLI) bin/console hautelook:fixtures:load
.PHONY: fixtures

run-console: ##@development Run custom command (usage example: make run comm='code:generate:module:yves test')
	$(CONSOLE) $(comm)
.PHONY: run-console

vendor: api/composer.json api/composer.lock
	$(CLI) composer install
