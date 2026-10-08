IMAGE := php85-workshop
TTY   := $(shell [ -t 0 ] && echo -it)
RUN   := docker run --rm $(TTY) --user $(shell id -u):$(shell id -g) -v "$(CURDIR)":/app -w /app

.PHONY: help build install test shell
.DEFAULT_GOAL := help

help: ## Show this help
	@grep -E '^[a-z-]+:.*## ' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*## "}; {printf "  make %-16s %s\n", $$1, $$2}'

build: ## Build the PHP 8.5 image
	docker build -t $(IMAGE) .

install: build ## Install the composer dependencies
	$(RUN) $(IMAGE) composer install

test: ## Run the tests, e.g. "make test" or "make test ex=03"
	$(RUN) $(IMAGE) vendor/bin/phpunit $(if $(ex),--testsuite ex$(ex))

shell: ## Open a shell inside the container
	$(RUN) $(IMAGE) bash
