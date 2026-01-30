#!make
-include .project

COMPOSER_FLAGS=--no-ansi --no-interaction --no-progress --no-scripts --optimize-autoloader --prefer-dist
ROOT = $(shell pwd)

PROJECT_NAME ?= $(shell read -p "Project Name (lowercase): " project; echo $$project)
ENV_THEME ?= $(shell read -p "Theme Name: " theme; echo $$theme)
ENV_REMOTE_REPO ?= $(shell read -p "Remote Repository: " repo; echo $$repo)
REMOTE_BRANCH ?= $(shell read -p "Pantheon Branch: " repo; echo $${repo:-master})
COMMIT_MSG ?= $(shell read -p "Commit Message: " commit; echo $$commit)
HOST_NAME ?= $(shell read -p "Host Name (http://kmag.local): " host; echo $${host:-kmag})
DB_NAME ?= $(shell read -p "DB Name (kmag): " name; echo $${name:-kmag})
DB_USER ?= $(shell read -p "DB User (root): " user; echo $${user:-root})
DB_PASS ?= $(shell read -p "DB Password (root): " pass; echo $${pass:-root})
ACF_PRO_KEY ?= $(shell read -p "ACF Pro Key: " acf; echo $$acf)
WPM_PRO_KEY ?= $(shell read -p "WP Migrate DB Key: " wpdb; echo $$wpdb)

GREEN=\033[0;32m
YELLOW=\033[1;33m
SET=\033[0m

.SILENT: ;	# no need for @
.ONESHELL: ;	# recipes execute in same shell
.PHONY: help
.DEFAULT_GOAL := help

build: ## Runs build scripts for included themes
	@echo "${GREEN}Running theme build scripts...${SET}"
	@cd ${ROOT}/app/themes/${ENV_THEME} && yarn install

clean: ## Clears composer's internal package cache
	composer clear-cache

create: ## Defines Pantheon remote repository and checkouts
	@if [ ! -f .env ]; then \
		cp -R .env.example .env; \
	fi;
	${MAKE} env
	${MAKE} remove-keepers
	${MAKE} install
	${MAKE} dev

deploy: ## Deploy packaged codebase to Pantheon remote
	@echo "${GREEN}Deploying current codebase to Pantheon remote...${SET}"
	${MAKE} package
	@cd ${ROOT}/wp/ && git add . && git commit -m "${COMMIT_MSG}" && git push
	${MAKE} dev

dev: ## Rename WordPress config file in /wp for local development
	@if [ -f wp/wp-config.php ]; then \
		mv wp/wp-config.php wp/.wp-config.php; \
	fi;

env: ## Generates environment file for WordPress installation
	rm -rf .env;
	@echo "${GREEN}Writing to environment file...${SET}"
	echo "DB_NAME=${DB_NAME} \n\
	DB_USER=${DB_USER} \n\
	DB_PASSWORD=${DB_PASS} \n\
	WP_ENV=development \n\
	WP_HOME=${HOST_NAME} \n\
	WP_SITEURL=\$${WP_HOME}/wp \n\
	ACF_PRO_KEY=${ACF_PRO_KEY} \n\
	WPM_PRO_KEY=${WPM_PRO_KEY}" >> .env;

help: ## Displays all available commands
	@echo "$$(tput bold)Available commands:$$(tput sgr0)"
	@echo
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[33m%-15s\033[0m %s\n", $$1, $$2}'
	@echo

install: ## Installs the composer project dependencies
	@echo "${GREEN}Building files...${SET}"
	composer install ${COMPOSER_FLAGS}

master-branch-check:
ifeq ("$(shell git rev-parse --abbrev-ref HEAD)", "main")
	@echo "Current branch is main"
else
	$(error Action requires the main branch)
endif

package: ## Builds working copies of themes and plugins within remote repo
	@echo "${GREEN}Packing up current build for remote repo...${SET}"
	rsync -ad --progress app/plugins wp/wp-content/
	rsync -ad --progress --exclude node_modules --exclude .git --exclude .gitignore app/themes wp/wp-content/
	${MAKE} prod

prod: ## Rename WordPress config file in /wp for Pantheon commits
	@if [ -f wp/.wp-config.php ]; then \
		mv wp/.wp-config.php wp/wp-config.php; \
	fi;

project:
	rm -rf .project;
	@echo "${GREEN}Writing to project file...${SET}"
	echo "ENV_THEME=${ENV_THEME} \n\
	REMOTE_REPO=${ENV_REMOTE_REPO}" >> .project;
	${MAKE} theme

remote: ## Clones remote repository to /wp directory.
	@if [ -d wp ]; then \
		rm -rf ${ROOT}/wp; \
	fi; \
	mkdir wp;
	@echo "${GREEN}Cloning remote repository...${SET}"
	@cd ${ROOT}/wp/ && git clone ${REMOTE_REPO} .

remove-keepers:
	rm -f app/**/.gitkeep

theme: ## Copies starter theme package to new theme directory as defined project name
	@if [ ! -d app/themes/${ENV_THEME} ]; then \
		cp -R app/themes/mc-wp-starter-theme app/themes/${ENV_THEME}; \
	fi; \

update: ## Updates your composer dependencies to the latest version according to composer.json
	composer update ${COMPOSER_FLAGS}
