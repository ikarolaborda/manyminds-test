PROJECT_NAME=manyminds-api

DOCKER_COMPOSE=docker-compose -p $(PROJECT_NAME)

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

restart:
	$(DOCKER_COMPOSE) down
	$(DOCKER_COMPOSE) up -d

logs:
	$(DOCKER_COMPOSE) logs -f

# Atalho para executar comandos no container mariadb.
db:
	$(DOCKER_COMPOSE) exec database mysql -u root -p

# Atalho para executar comandos no container PHP.
php:
	$(DOCKER_COMPOSE) exec php bash

# Shortcut for running CodeIgniter commands inside the PHP container.
ci:
	$(DOCKER_COMPOSE) exec php php index.php
